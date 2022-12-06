<?php
    /**
     * @Thomas-Athanasiou
     *
     * @author Thomas Athanasiou {thomas@hippiemonkeys.com}
     * @link https://hippiemonkeys.com
     * @link https://github.com/Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys Web Inteligence EE All Rights Reserved.
     * @license http://www.gnu.org/licenses/ GNU General Public License, version 3
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Model;

    use SoapClient as Client,
        Psr\Log\LoggerInterface,
        Magento\Framework\DataObject,
        Magento\Framework\DataObjectFactory,
        Magento\Framework\App\Config\ScopeConfigInterface,
        Magento\Framework\Webapi\Soap\ClientFactory,
        Magento\Directory\Helper\Data as DirectoryData,
        Magento\CatalogInventory\Api\StockRegistryInterface,
        Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory as RateErrorFactory,
        Magento\Quote\Model\Quote\Address\RateResult\MethodFactory as RateMethodFactory,
        Magento\Shipping\Model\Rate\ResultFactory as RateResultFactory,
        Magento\Shipping\Model\Tracking\ResultFactory as TrackingResultFactory,
        Magento\Shipping\Model\Tracking\Result\ErrorFactory as TrackingErrorFactory,
        Magento\Shipping\Model\Tracking\Result\StatusFactory as TrackingStatusFactory,
        Hippiemonkeys\Shipping\Model\AbstractCarrierOnline,
        Hippiemonkeys\ShippingTaxydromiki\Exception\AuthenticateException,
        Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\JobRepositoryInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterfaceFactory;

    abstract class AbstractCarrier
    extends AbstractCarrierOnline
    implements CarrierInterface
    {
        /**
         * Does a create job request
         *
         * @access protected
         *
         * @param \Magento\Framework\DataObject $request
         *
         * @return object
         */
        abstract protected function doCreateJobRequest(DataObject $request): object;

        protected const
            CODE                    = 'hippiemonkeysshippingtaxydromiki',

            DEFAULT_VOUCHER_NUMBER  = '',
            DEFAULT_SUB_CODE        = '',
            DEFAULT_BELONGS_TO      = '',
            DEFAULT_DELIVER_TO      = '',
            DEFAULT_RECEIVED_DATE   = '',

            VOUCHER_TYPE            = 'Voucher';

        /**
         * Constructor
         *
         * @access public
         *
         * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
         * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
         * @param \Psr\Log\LoggerInterface $logger
         * @param \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory
         * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
         * @param \Magento\Framework\DataObjectFactory $dataOjectFactory
         * @param \Magento\Shipping\Model\Tracking\ResultFactory $trackingResultFactory
         * @param \Magento\Shipping\Model\Tracking\Result\ErrorFactory $trackingErrorFactory
         * @param \Magento\Shipping\Model\Tracking\Result\StatusFactory $trackingStatusFactory
         * @param \Magento\Directory\Helper\Data $directoryData
         * @param \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterfaceFactory $jobFactory,
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\JobRepositoryInterface $jobRepository,
         * @param \Magento\Framework\Webapi\Soap\ClientFactory $clientFactory,
         * @param array $data
         */
        public function __construct(
            ScopeConfigInterface $scopeConfig,
            RateErrorFactory $rateErrorFactory,
            LoggerInterface $logger,
            RateResultFactory $rateResultFactory,
            RateMethodFactory $rateMethodFactory,
            DataObjectFactory $dataOjectFactory,
            TrackingResultFactory $trackingResultFactory,
            TrackingErrorFactory $trackingErrorFactory,
            TrackingStatusFactory $trackingStatusFactory,
            DirectoryData $directoryData,
            StockRegistryInterface $stockRegistry,
            JobInterfaceFactory $jobFactory,
            JobRepositoryInterface $jobRepository,
            ClientFactory $clientFactory,
            array $data = []
        )
        {
            parent::__construct(
                $scopeConfig,
                $rateErrorFactory,
                $logger,
                $rateResultFactory,
                $rateMethodFactory,
                $dataOjectFactory,
                $trackingResultFactory,
                $trackingErrorFactory,
                $trackingStatusFactory,
                $directoryData,
                $stockRegistry,
                $data
            );
            $this->_jobFactory      = $jobFactory;
            $this->_jobRepository   = $jobRepository;
            $this->_clientFactory   = $clientFactory;
        }

        /**
         * @inheritdoc
         */
        public function getTracking($trackings)
        {
            $result         = $this->getTrackingResultFactory()->create();
            $carrierCode    = $this->getCarrierCode();
            $carrierTitle   = $this->getCarrierTitle();
            foreach((array) $trackings as $tracking)
            {
                $trackAndTraceResult = $this->trackAndTrace($tracking, $this->getSoapLanguage())->TrackAndTraceResult ?? null;
                if($trackAndTraceResult && ($trackAndTraceResult->Result ?? static::RESULT_CODE_INVALID) === static::RESULT_CODE_SUCCESS)
                {
                    $trackSummary 	= [];
                    $checkpoints 	= $trackAndTraceResult->Checkpoints;
                    if(is_array($checkpoints->Checkpoint) && count($checkpoints->Checkpoint))
                    {
                        $checkpoints = $checkpoints->Checkpoint;
                    }

                    foreach((array) $checkpoints as $checkpoint)
                    {
                        $trackSummary[] = __('%1 - %2 at %3', $checkpoint->Shop ?? '', $checkpoint->Status ?? '', date('d/m/Y, H:i', \strtotime($checkpoint->StatusDate)) ?? date('d/m/Y, H:i'));
                    }

                    $trackStatus = $this->getTrackingStatusFactory()->create();
                    $trackStatus->setCarrier($carrierCode);
                    $trackStatus->setCarrierTitle($carrierTitle);
                    $trackStatus->setTrackSummary(implode(' → ', $trackSummary));
                    $trackStatus->setTracking($tracking);
                    $result->append($trackStatus);
                }
            }
            return $result;
        }

        /**
         * @inheritdoc
         */
        public function closePendingJobs(): object
        {
            return $this->getClient()->ClosePendingJobs(
                ['sAuthKey' => $this->getAuthenticateKey()]
            );
        }

        /**
         * @inheritdoc
         */
        public function closePendingJobsByDate(string $dateFrom, string $dateTo): object
        {
            return $this->getClient()->ClosePendingJobsByDate(
                ['sAuthKey' => $this->getAuthenticateKey(), 'dFr' => $dateFrom, 'dTo' => $dateTo]
            );
        }

        /**
         * @inheritdoc
         */
        public function cancelJob(int $jobId, bool $cancel): object
        {
            return $this->getClient()->CancelJob(
                ['sAuthKey' => $this->getAuthenticateKey(), 'nJobId' => $jobId, 'bCancel' => $cancel]
            );
        }

        /**
         * @inheritdoc
         */
        public function getVoucherJob(int $jobId): object
        {
            return $this->getClient()->GetVoucherJob(
                ['sAuthKey' => $this->getAuthenticateKey(), 'nJobId' => $jobId]
            );
        }

        /**
         * @inheritdoc
         */
        public function getJobsFromOrderId(string $orderId): object
        {
            return $this->getClient()->GetJobsFromOrderId(
                ['sAuthKey' => $this->getAuthenticateKey(), 'sOrderId' => $orderId]
            );
        }

        /**
         * @inheritdoc
         */
        public function getVouchersPdf(array $vouchers) : object
        {
            $client = $this->getClient();
            $content = static::RESULT_CODE_INVALID;

            try
            {
                $content = $client->GetVouchersPdf(
                    [
                        'authKey' => $this->getAuthenticateKey(),
                        'format' => $this->getPdfFormat(),
                        'extraInfoFormat' => $this->getPdfExtraInfoFormat(),
                        'voucherNumbers' => $vouchers
                    ]
                );
            }
            catch(\SoapFault $soapFault)
            {
                $content = $client->__getLastResponse();
            }

            $getVouchersPdfResult = new \stdClass;
            $getVouchersPdfResult->Result = is_numeric($content) ? (int) $content : static::RESULT_CODE_SUCCESS;
            $getVouchersPdfResult->Content = $content;

            $result = new \stdClass;
            $result->GetVouchersPdfResult = $getVouchersPdfResult;
            return $result;
        }

        /**
         * @inheritdoc
         */
        public function getShopsList(): object
        {
            return $this->getClient()->GetShopsList(
                ['authKey' => $this->getAuthenticateKey()]
            );
        }

        /**
         * @inheritdoc
         */
        public function trackAndTrace(string $voucher, string $language): object
        {
            return $this->getClient()->TrackAndTrace(
                ['authKey' => $this->getAuthenticateKey(), 'voucherNo' => $voucher, 'language' => $language]
            );
        }

        /**
         * @inheritdoc
         */
        public function trackDeliveryStatus(string $voucher, string $language): object
        {
            return $this->getClient()->TrackDeliveryStatus(
                ['authKey' => $this->getAuthenticateKey(), 'voucherNo' => $voucher, 'language' => $language]
            );
        }

        /**
         * Sends an Authenticate request to Taxydromiki service
         *
         * @access protected
         *
         * @return object
         */
        protected function authenticate(): object
        {
            return $this->getClient()->Authenticate(
                ['sUsrName' => $this->getUsername(), 'sUsrPwd' => $this->getPassword(), 'applicationKey' => $this->getApplicationKey()]
            );
        }

        /**
         * @inheritdoc
         */
        public function createJob(
            string $orderId,
            string $name,
            string $address,
            string $city,
            string $telephone,
            string $zip,
            string $destination,
            string $courier,
            int $pieces,
            float $weight,
            array $comments,
            array $services,
            float $codAmount,
            float $insAmoubnt,
            string $voucherNumber,
            string $subCode,
            string $belongsTo,
            string $deliverTo,
            string $receivedDate
        ): object
        {
            return $this->getClient()->CreateJob(
                [
                    'sAuthKey' => $this->getAuthenticateKey(),
                    'oVoucher' => [
                        'OrderId'       => $orderId,
                        'Name'          => \mb_strtoupper($name),
                        'Address'       => $address,
                        'City'          => $city,
                        'Telephone'     => $telephone,
                        'Zip'           => \str_replace(' ', '', $zip),
                        'Destination'   => $destination,
                        'Courier'       => $courier,
                        'Pieces'        => $pieces,
                        'Weight'        => $weight,
                        'Comments'      => \implode(', ', $comments),
                        'Services'      => \implode(',', $services),
                        'CodAmount'     => $codAmount,
                        'InsAmount'     => $insAmoubnt,
                        'VoucherNumber' => static::DEFAULT_VOUCHER_NUMBER,
                        'SubCode'       => static::DEFAULT_SUB_CODE,
                        'BelongsTo'     => static::DEFAULT_BELONGS_TO,
                        'DeliverTo'     => static::DEFAULT_DELIVER_TO,
                        'ReceivedDate'  => \date('Y-m-d')
                    ],
                    'eType' => static::VOUCHER_TYPE
                ]
            );
        }

        /**
         * @inheritdoc
         */
        protected function processShipmentRequest(DataObject $request): DataObject
        {
            $result = $this->getDataObjectFactory()->create();
            $createJobResult = $this->doCreateJobRequest($request)->CreateJobResult;
            $createJobResultCode = $createJobResult->Result ?? static::RESULT_CODE_INVALID;
            if($createJobResultCode === static::RESULT_CODE_SUCCESS)
            {
                $voucher = $createJobResult->Voucher;

                $job = $this->getJobFactory()->create();
                $job->setJobId($createJobResult->JobId);
                $job->setVoucher($voucher);
                $job->setCanceled(false);
                $job->setClosed(false);
                $job->setStatus(JobInterface::STATUS_NEW);

                $this->getJobRepository()->save($job);

                $result->setTrackingNumber($voucher);

                $labelResult = $this->getVouchersPdf( [$voucher] )->GetVouchersPdfResult ?? null;
                if($labelResult && ($labelResult->Result ?? static::RESULT_CODE_INVALID) === static::RESULT_CODE_SUCCESS)
                {
                    $result->setShippingLabelContent( $labelResult->Content );
                }
            }
            else
            {
                $result->setHasErrors($hasErrors);
                $result->setErrors( __('There has been an error with this shipment Request, Error Code: %1', $createJobResultCode) );
            }
            return $result;
        }

        /**
         * Soap Client property
         *
         * @access private
         *
         * @var string $_authenticateKey
         */
        private $_authenticateKey;

        /**
         * Gets Session Token
         *
         * @access protected
         *
         * @return string
         */
        protected function getAuthenticateKey() : string
        {
            $authenticateKey = $this->_authenticateKey;
            if(!$authenticateKey)
            {
                $authenticateResult = $this->authenticate()->AuthenticateResult ?? null;
                if($authenticateResult && ($authenticateResult->Result ?? static::RESULT_CODE_INVALID) !== static::RESULT_CODE_SUCCESS)
                {
                    throw new AuthenticateException( __('Authorization with taxydromiki service failed.') );
                }
                $authenticateKey = $authenticateResult->Key ?? '';
                $this->setAuthenticateKey($authenticateKey);
            }
            return $authenticateKey;
        }

        /**
         * Sets Authenticate Key
         *
         * @access protected
         *
         * @param string $authenticateKey
         */
        protected function setAuthenticateKey(string $authenticateKey): void
        {
            $this->_authenticateKey = $authenticateKey;
        }

        /**
         * Client Factory Property
         *
         * @access private
         *
         * @var \Magento\Framework\Webapi\Soap\ClientFactory $_clientFactory
         */
        private $_clientFactory;

        /**
         * Gets Client Factory
         *
         * @access protected
         *
         * @return \Magento\Framework\Webapi\Soap\ClientFactory
         */
        protected function getClientFactory(): ClientFactory
        {
            return $this->_clientFactory;
        }

        /**
         * Client property
         *
         * @access private
         *
         * @var \SoapClient $_client
         */
        private $_client;

        /**
         * Gets Client
         *
         * @access protected
         *
         * @return \SoapClient
         */
        protected function getClient() : Client
        {
            $client = $this->_client;
            if(!$client)
            {
                $client = $this->getClientFactory()->create(
                    $this->getWsdlUrl(),
                    ['cache_wsdl' => \WSDL_CACHE_BOTH, 'trace' => true]
                );
                $this->setClient($client);
            }
            return $client;
        }

        /**
         * Sets Client
         *
         * @access protected
         *
         * @param \SoapClient $client
         */
        protected function setClient(Client $client) : void
        {
            $this->_client = $client;
        }

        /**
         * Gets Wsdl Url
         *
         * @access protected
         *
         * @return string
         */
        protected function getWsdlUrl(): string
        {
            return $this->getConfigData('wsdl_url');
        }

        /**
         * Gets Pdf Format
         *
         * @access protected
         *
         * @return string
         */
        protected function getPdfFormat() : string
        {
            return $this->getConfigData('pdf_format');
        }

        /**
         * Gets Pdf Extra Info Format
         *
         * @access protected
         *
         * @return string
         */
        protected function getPdfExtraInfoFormat() : string
        {
            return $this->getConfigData('pdf_extra_info_format');
        }

        /**
         * Gets taxydromiki Username credential
         *
         * @access private
         *
         * @return string
         */
        private function getUsername(): string
        {
            return (string) $this->getConfigData('taxydromiki_username');
        }

        /**
         * Gets taxydromiki Password credential
         *
         * @access private
         *
         * @return string
         */
        private function getPassword(): string
        {
            return (string) $this->getConfigData('taxydromiki_password');
        }

        /**
         * Gets taxydromiki Application Key credential
         *
         * @access private
         *
         * @return string
         */
        private function getApplicationKey(): string
        {
            return (string) $this->getConfigData('taxydromiki_api_key');
        }

        /**
         * Gets taxydromiki Application Key credential
         *
         * @access private
         *
         * @return string
         */
        private function getSoapLanguage(): string
        {
            return $this->getConfigData('soap_language');
        }

        /**
         * Job Factory property
         *
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\JobInterfaceFactory $_jobFactory
         */
        private $_jobFactory;

        /**
         * Gets Job Factory
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\JobInterfaceFactory
         */
        protected function getJobFactory() : JobInterfaceFactory
        {
            return $this->_jobFactory;
        }

        /**
         * Job Repository property
         *
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\JobRepositoryInterface $_jobRepository
         */
        private $_jobRepository;

        /**
         * Gets Job Factiory
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\JobRepositoryInterface
         */
        protected function getJobRepository() : JobRepositoryInterface
        {
            return $this->_jobRepository;
        }
    }
?>