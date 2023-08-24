<?php
    /**
     * @Thomas-Athanasiou
     *
     * @author Thomas Athanasiou {thomas@hippiemonkeys.com}
     * @link https://hippiemonkeys.com
     * @link https://github.com/Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys Web Intelligence EE All Rights Reserved.
     * @license http://www.gnu.org/licenses/ GNU General Public License, version 3
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Model;

    use SoapClient as Client,
        Magento\Framework\Webapi\Soap\ClientFactory,
        Hippiemonkeys\Core\Api\Helper\ConfigInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\TaxydromikiInterface,
        Hippiemonkeys\ShippingTaxydromiki\Exception\AuthenticateException;

    class Taxydromiki
    implements TaxydromikiInterface
    {
        protected const
            DEFAULT_VOUCHER_NUMBER  = '',
            DEFAULT_SUB_CODE = '',
            DEFAULT_BELONGS_TO = '',
            DEFAULT_DELIVER_TO = '',
            DEFAULT_RECEIVED_DATE = '',
            VOUCHER_TYPE = 'Voucher';

        /**
         * Constructor
         *
         * @access public
         *
         * @param \Hippiemonkeys\Core\Api\Helper\ConfigInterface $config
         * @param \Magento\Framework\Webapi\Soap\ClientFactory $clientFactory
         * @param array $data
         */
        public function __construct(
            ConfigInterface $config,
            ClientFactory $clientFactory
        )
        {
            $this->_config = $config;
            $this->_clientFactory = $clientFactory;
        }

        /**
         * {@inheritdoc}
         */
        public function closePendingJobs(): object
        {
            return $this->getClient()->ClosePendingJobs(
                ['sAuthKey' => $this->getAuthenticateKey()]
            );
        }

        /**
         * {@inheritdoc}
         */
        public function closePendingJobsByDate(string $dateFrom, string $dateTo): object
        {
            return $this->getClient()->ClosePendingJobsByDate(
                ['sAuthKey' => $this->getAuthenticateKey(), 'dFr' => $dateFrom, 'dTo' => $dateTo]
            );
        }

        /**
         * {@inheritdoc}
         */
        public function cancelJob(int $jobId, bool $cancel): object
        {
            return $this->getClient()->CancelJob(
                ['sAuthKey' => $this->getAuthenticateKey(), 'nJobId' => $jobId, 'bCancel' => $cancel]
            );
        }

        /**
         * {@inheritdoc}
         */
        public function getVoucherJob(int $jobId): object
        {
            return $this->getClient()->GetVoucherJob(
                ['sAuthKey' => $this->getAuthenticateKey(), 'nJobId' => $jobId]
            );
        }

        /**
         * {@inheritdoc}
         */
        public function getJobsFromOrderId(string $orderId): object
        {
            return $this->getClient()->GetJobsFromOrderId(
                ['sAuthKey' => $this->getAuthenticateKey(), 'sOrderId' => $orderId]
            );
        }

        /**
         * {@inheritdoc}
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
            catch(\SoapFault)
            {
                $content = $client->__getLastResponse();
            }

            $getVouchersPdfResult = new \stdClass;
            $getVouchersPdfResult->Result = \is_numeric($content) ? (int) $content : static::RESULT_CODE_SUCCESS;
            $getVouchersPdfResult->Content = $content;

            $result = new \stdClass;
            $result->GetVouchersPdfResult = $getVouchersPdfResult;
            return $result;
        }

        /**
         * {@inheritdoc}
         */
        public function getShopsList(): object
        {
            return $this->getClient()->GetShopsList(
                ['authKey' => $this->getAuthenticateKey()]
            );
        }

        /**
         * {@inheritdoc}
         */
        public function trackAndTrace(string $voucher, string $language): object
        {
            return $this->getClient()->TrackAndTrace(
                ['authKey' => $this->getAuthenticateKey(), 'voucherNo' => $voucher, 'language' => $language]
            );
        }

        /**
         * {@inheritdoc}
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
         * {@inheritdoc}
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
                        'OrderId' => $orderId,
                        'Name' => \mb_strtoupper($name),
                        'Address' => $address,
                        'City' => $city,
                        'Telephone' => $telephone,
                        'Zip' => \str_replace(' ', '', $zip),
                        'Destination' => $destination,
                        'Courier' => $courier,
                        'Pieces' => $pieces,
                        'Weight' => $weight,
                        'Comments' => \implode(', ', $comments),
                        'Services' => \implode(',', $services),
                        'CodAmount' => $codAmount,
                        'InsAmount' => $insAmoubnt,
                        'VoucherNumber' => static::DEFAULT_VOUCHER_NUMBER,
                        'SubCode' => static::DEFAULT_SUB_CODE,
                        'BelongsTo' => static::DEFAULT_BELONGS_TO,
                        'DeliverTo' => static::DEFAULT_DELIVER_TO,
                        'ReceivedDate' => \date('Y-m-d')
                    ],
                    'eType' => static::VOUCHER_TYPE
                ]
            );
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
         * Config property
         *
         * @access private
         *
         * @var \Hippiemonkeys\Core\Api\Helper\ConfigInterface $_config
         */
        private $_config;

        /**
         * Gets Config
         *
         * @access protected
         *
         * @return \Hippiemonkeys\Core\Api\Helper\ConfigInterface
         */
        protected function getConfig(): ConfigInterface
        {
            return $this->_config;
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
            return $this->getConfig()->getData('wsdl_url');
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
            return $this->getConfig()->getData('pdf_format');
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
            return $this->getConfig()->getData('pdf_extra_info_format');
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
            return (string) $this->getConfig()->getData('taxydromiki_username');
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
            return (string) $this->getConfig()->getData('taxydromiki_password');
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
            return (string) $this->getConfig()->getData('taxydromiki_api_key');
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
            return (string) $this->getConfig()->getData('soap_language');
        }
    }
?>