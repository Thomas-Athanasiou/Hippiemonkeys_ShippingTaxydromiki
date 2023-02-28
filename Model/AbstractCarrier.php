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

    use  Psr\Log\LoggerInterface,
        Magento\Framework\DataObject,
        Magento\Framework\DataObjectFactory,
        Magento\Framework\Api\SearchCriteriaBuilder,
        Magento\Framework\App\Config\ScopeConfigInterface,
        Magento\Directory\Helper\Data as DirectoryData,
        Magento\Directory\Api\CountryInformationAcquirerInterface,
        Magento\CatalogInventory\Api\StockRegistryInterface,
        Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory as RateErrorFactory,
        Magento\Quote\Model\Quote\Address\RateResult\MethodFactory as RateMethodFactory,
        Magento\Sales\Api\Data\ShipmentTrackInterface,
        Magento\Sales\Api\ShipmentTrackRepositoryInterface,
        Magento\Shipping\Model\Rate\ResultFactory as RateResultFactory,
        Magento\Shipping\Model\Tracking\ResultFactory as TrackingResultFactory,
        Magento\Shipping\Model\Tracking\Result\ErrorFactory as TrackingErrorFactory,
        Magento\Shipping\Model\Tracking\Result\StatusFactory as TrackingStatusFactory,
        Hippiemonkeys\ShippingTrack\Api\Data\StatusInterface,
        Hippiemonkeys\ShippingTrack\Api\StatusRepositoryInterface,
        Hippiemonkeys\ShippingTrack\Model\AbstractCarrier as ParentAbstractCarrier,
        Hippiemonkeys\ShippingTrack\Api\Data\HistoryInterfaceFactory,
        Hippiemonkeys\ShippingTrack\Api\Data\PickupLocationInterface,
        Hippiemonkeys\ShippingTrack\Api\Data\PickupLocationInterfaceFactory,
        Hippiemonkeys\ShippingTrack\Api\PickupLocationRepositoryInterface,
        Hippiemonkeys\ShippingTrack\Exception\NoSuchEntityException as TrackNoSuchEntityException,
        Hippiemonkeys\ShippingTaxydromiki\Exception\NoSuchEntityException,
        Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\TaxydromikiInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\JobRepositoryInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterfaceFactory,
        Hippiemonkeys\ShippingTaxydromiki\Api\StatusResolutionRepositoryInterface;

    abstract class AbstractCarrier
    extends ParentAbstractCarrier
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
            CODE = 'hippiemonkeysshippingtaxydromiki',
            DEFAULT_VOUCHER_NUMBER  = '',
            DEFAULT_SUB_CODE = '',
            DEFAULT_BELONGS_TO = '',
            DEFAULT_DELIVER_TO = '',
            DEFAULT_RECEIVED_DATE = '',
            VOUCHER_TYPE = 'Voucher',
            FORMAT_CREATED_AT = 'd/m/Y H:i:s',
            FORMAT_CREATED_AT_SQL = 'Y-m-d H:i:s',
            FORMAT_PICKUP_LOCATION_CODE = '%s:%s:%s:%s:%s:%s:%s',
            CONF_DEFAULT_HISTORY_STATUS_ID = 'default_history_status_id';

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
         * @param \Magento\Sales\Api\ShipmentTrackRepositoryInterface $shipmentTrackRepository
         * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
         * @param \Hippiemonkeys\ShippingTrack\Api\Data\HistoryInterfaceFactory $historyFactory
         * @param \Hippiemonkeys\ShippingTrack\Api\Data\PickupLocationInterfaceFactory $pickupLocationFactory
         * @param \Hippiemonkeys\ShippingTrack\Api\PickupLocationRepositoryInterface $pickupLocationRepository
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\TaxydromikiInterface $taxydromiki
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterfaceFactory $jobFactory
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\JobRepositoryInterface $jobRepository
         * @param \Hippiemonkeys\ShippingTrack\Api\StatusRepositoryInterface $statusRepository
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\StatusResolutionRepositoryInterface $statusResolutionRepository
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
            ShipmentTrackRepositoryInterface $shipmentTrackRepository,
            SearchCriteriaBuilder $searchCriteriaBuilder,
            HistoryInterfaceFactory $historyFactory,
            PickupLocationInterfaceFactory $pickupLocationFactory,
            PickupLocationRepositoryInterface $pickupLocationRepository,
            CountryInformationAcquirerInterface $countryInformationAcquirer,
            TaxydromikiInterface $taxydromiki,
            JobInterfaceFactory $jobFactory,
            JobRepositoryInterface $jobRepository,
            StatusRepositoryInterface $statusRepository,
            StatusResolutionRepositoryInterface $statusResolutionRepository,
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
                $shipmentTrackRepository,
                $searchCriteriaBuilder,
                $data
            );

            $this->_historyFactory = $historyFactory;
            $this->_pickupLocationFactory = $pickupLocationFactory;
            $this->_pickupLocationRepository = $pickupLocationRepository;
            $this->_countryInformationAcquirer = $countryInformationAcquirer;
            $this->_taxydromiki = $taxydromiki;
            $this->_jobFactory = $jobFactory;
            $this->_jobRepository = $jobRepository;
            $this->_statusRepository = $statusRepository;
            $this->_statusResolutionRepository = $statusResolutionRepository;
        }

        /**
         * {@inheritdoc}
         */
        public function getShipmentTrackHistories(ShipmentTrackInterface $shipmentTrack): array
        {
            $histories = [];

            $logger = $this->getLogger();
            $historyFactory = $this->getHistoryFactory();

            $trackAndTraceResult = $this->getTaxydromiki()->trackAndTrace($shipmentTrack->getTrackNumber(), $this->getSoapLanguage())->TrackAndTraceResult ?? null;
            if($trackAndTraceResult !== null && $this->getIsSuccessResult($trackAndTraceResult))
            {
                $checkpoints = $trackAndTraceResult->Checkpoints ?? [];
                if(isset($checkpoints->Checkpoint) && is_array($checkpoints->Checkpoint) && count($checkpoints->Checkpoint))
                {
                    $checkpoints = $checkpoints->Checkpoint;
                }

                $statusResolutionRepository = $this->getStatusResolutionRepository();
                foreach(\array_values((array) $checkpoints) as $workflowPosition => $checkpoint)
                {
                    $checkpointStatus = $checkpoint->Status ?? '';
                    if($checkpointStatus !== '')
                    {
                        try
                        {
                            /* $soapShop = $checkpoint->Shop ?? null; */
                            $soapShop = null;

                            $history = $historyFactory->create();
                            $history->setShipmentTrack($shipmentTrack);
                            $history->setStatus($statusResolutionRepository->getByCode($checkpointStatus)->getStatus());
                            $history->setPickupLocation(($soapShop === null || $soapShop === '') ? null : $this->getPickupLocationBySoapShop($soapShop));
                            $history->setCreatedAt(date(static::FORMAT_CREATED_AT_SQL, \strtotime($checkpoint->StatusDate)) ?? date(static::FORMAT_CREATED_AT_SQL));
                            $history->setWorkflowPosition((int) $workflowPosition);

                            $histories[] = $history;
                        }
                        catch (NoSuchEntityException)
                        {
                            $logger->error(__('Unable to process history item with Status Code %1', $checkpointStatus));
                        }
                        catch (TrackNoSuchEntityException)
                        {
                            $logger->error(__('Unable to process history item details with Status Code %1', $checkpointStatus));
                        }
                    }
                }
            }
            else
            {
                $logger->error(__('Unable to process history, taxydromiki service responded with error: %1', $trackAndTraceResult->Result ?? 0));

                try
                {
                    $history = $historyFactory->create();
                    $history->setShipmentTrack($shipmentTrack);
                    $history->setStatus($this->getDefaultHistoryStatus());
                    $history->setPickupLocation(null);
                    $history->setCreatedAt(date(static::FORMAT_CREATED_AT_SQL));
                    $history->setWorkflowPosition(2048);
                    $histories[] = $history;
                }
                catch (TrackNoSuchEntityException)
                {
                    $logger->error(__('Invalid Default History Status Id'));
                }
            }

            return $histories;
        }

        /**
         * Gets Unique Pickup location by the given name, if there are more than one pickup locations returns null
         *
         * @access protected
         *
         * @param string $name
         */
        protected function getUniquePickupLocationByNameOrNull(string $name): ?PickupLocationInterface
        {
            return null;
        }

        /**
         * {@inheritdoc}
         */
        public function getPickupLocations(): array
        {
            /**
             * @var \Hippiemonkeys\ShippingTrack\Api\Data\PickupLocationInterface[] $pickupLocations
             */
            $pickupLocations = [];

            $getShopsListResult = $this->getTaxydromiki()->getShopsList()->GetShopsListResult;
            if($this->getIsSuccessResult($getShopsListResult))
            {
                foreach((array) $getShopsListResult->Shops->Shop ?? [] as $soapShop)
                {
                    $pickupLocation = $this->getUpdatedPickupLocation($soapShop);
                    if($pickupLocation !== null)
                    {
                        $pickupLocations[] = $pickupLocation;
                    }
                }
            }

            return $pickupLocations;
        }

        /**
         * Gets Updated Pickup Location
         *
         * @param object $soapShop
         *
         * @return \Hippiemonkeys\ShippingTrack\Api\Data\PickupLocationInterface|null
         */
        protected function getUpdatedPickupLocation(object $soapShop): PickupLocationInterface
        {
            $pickupLocation = null;
            try
            {
                $pickupLocation = $this->getPickupLocationBySoapShop($soapShop);
            }
            catch (TrackNoSuchEntityException)
            {
                $pickupLocation = $this->getPickupLocationFactory()->create();
                $pickupLocation->setCarrierCode($this->getCarrierCode());
            }

            if($pickupLocation !== null)
            {
                $pickupLocation->setCode($this->getSoapShopCode($soapShop))
                    ->setName($soapShop->Name)
                    ->setState($soapShop->State)
                    ->setCity($soapShop->City)
                    ->setCountryInformation($this->getCountryInformationAcquirer()->getCountryInfo($soapShop->Country))
                    ->setAddress($soapShop->Address)
                    ->setTelephone($soapShop->Telephone)
                    ->setPostalCode($soapShop->Zip)
                    ->setEmail($soapShop->Email)
                    ->setLongitude((float) ($soapShop->Longitude))
                    ->setLatitude((float) ($soapShop->Latitude));
            }

            return $pickupLocation;
        }

        protected function getDefaultHistoryStatus(): StatusInterface
        {
            return $this->getStatusRepository()->getById(
                $this->getConfigData(static::CONF_DEFAULT_HISTORY_STATUS_ID)
            );
        }

        /**
         * Gets Pickup Location by Soap Shop
         *
         * @access protected
         *
         * @param object $soapShop
         *
         * @return \Hippiemonkeys\ShippingTrack\Api\Data\PickupLocationInterface
         */
        protected function getPickupLocationBySoapShop(object $soapShop): PickupLocationInterface
        {
            return $this->getPickupLocationRepository()->getByCodeAndTracker($this->getSoapShopCode($soapShop), $this);
        }

        /**
         * Gets Soap Shop Code
         *
         * @access protected
         *
         * @param object $soapShop
         *
         * @return string
         */
        protected function getSoapShopCode(object $soapShop): string
        {
            return \md5(
                \sprintf(
                    static::FORMAT_PICKUP_LOCATION_CODE,
                    $soapShop->Code ?? '',
                    $soapShop->Code2 ?? '',
                    $soapShop->Name ?? '',
                    $soapShop->Country ?? '',
                    $soapShop->State ?? '',
                    $soapShop->City ?? '',
                    $soapShop->Address ?? ''
                ),
                false
            );
        }

        /**
         * {@inheritdoc}
         */
        protected function processShipmentRequest(DataObject $request): DataObject
        {
            $result = $this->getDataObjectFactory()->create();
            $createJobResult = $this->doCreateJobRequest($request)->CreateJobResult;
            if($this->getIsSuccessResult($createJobResult))
            {
                $voucher = $createJobResult->Voucher;

                $job = $this->getJobFactory()->create();
                $job->setJobId($createJobResult->JobId);
                $job->setVoucher($voucher);
                $job->setCanceled(false);
                $job->setClosed(false);

                $this->getJobRepository()->save($job);

                $result->setTrackingNumber($voucher);

                $labelResult = $this->getTaxydromiki()->getVouchersPdf([$voucher])->GetVouchersPdfResult ?? null;
                if($labelResult && $this->getIsSuccessResult($labelResult))
                {
                    $result->setShippingLabelContent($labelResult->Content);
                }
            }
            else
            {
                $result->setHasErrors(true);
                $result->setErrors(
                    __(
                        'There has been an error with this shipment Request, Error Code: %1',
                        $createJobResult->Result ?? TaxydromikiInterface::RESULT_CODE_INVALID
                    )
                );
            }
            return $result;
        }

        /**
         * Gets wether the result represents a successful response
         *
         * @access protected
         *
         * @return bool
         */
        protected function getIsSuccessResult(object $result): bool
        {
            return ($result->Result ?? TaxydromikiInterface::RESULT_CODE_INVALID) === TaxydromikiInterface::RESULT_CODE_SUCCESS;
        }

        /**
         * Taxydromiki property
         *
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\TaxydromikiInterface $_taxydromiki
         */
        private $_taxydromiki;

        /**
         * Gets Taxydromiki
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\TaxydromikiInterface
         */
        protected function getTaxydromiki(): TaxydromikiInterface
        {
            return $this->_taxydromiki;
        }

        /**
         * Job Factory property
         *
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterfaceFactory $_jobFactory
         */
        private $_jobFactory;

        /**
         * Gets Job Factory
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterfaceFactory
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

        /**
         * Status Resolution Repository property
         *
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\StatusResolutionRepositoryInterface $_statusResolutionRepository
         */
        private $_statusResolutionRepository;

        /**
         * Gets Status Resolution Repository
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\StatusResolutionRepositoryInterface
         */
        protected function getStatusResolutionRepository(): StatusResolutionRepositoryInterface
        {
            return $this->_statusResolutionRepository;
        }

        /**
         * Status Repository property
         *
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTrack\Api\StatusRepositoryInterface $_statusRepository
         */
        private $_statusRepository;

        /**
         * Gets Status Repository
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTrack\Api\StatusRepositoryInterface
         */
        protected function getStatusRepository(): StatusRepositoryInterface
        {
            return $this->_statusRepository;
        }

        /**
         * History Factory property
         *
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTrack\Api\Data\HistoryInterfaceFactory $_historyFactory
         */
        private $_historyFactory;

        /**
         * Gets History Factory
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTrack\Api\Data\HistoryInterfaceFactory
         */
        protected function getHistoryFactory(): HistoryInterfaceFactory
        {
            return $this->_historyFactory;
        }

        /**
         * Pickup Location Factory property
         *
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTrack\Api\Data\PickupLocationInterfaceFactory $_pickupLocationFactory
         */
        private $_pickupLocationFactory;

        /**
         * Gets Pickup Location Factory
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTrack\Api\Data\PickupLocationInterfaceFactory
         */
        protected function getPickupLocationFactory(): PickupLocationInterfaceFactory
        {
            return $this->_pickupLocationFactory;
        }

        /**
         * Pickup Location Repository property
         *
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTrack\Api\PickupLocationRepositoryInterface $_pickupLocationRepository
         */
        private $_pickupLocationRepository;

        /**
         * Gets Pickup Location Repository
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTrack\Api\PickupLocationRepositoryInterface
         */
        protected function getPickupLocationRepository(): PickupLocationRepositoryInterface
        {
            return $this->_pickupLocationRepository;
        }

        /**
         * Country Information Acquirer property
         *
         * @access private
         *
         * @var \Magento\Directory\Api\CountryInformationAcquirerInterface $_countryInformationAcquirer
         */
        private $_countryInformationAcquirer;

        /**
         * Gets Country Information Acquirer
         *
         * @access protected
         *
         * @return \Magento\Directory\Api\CountryInformationAcquirerInterface
         */
        protected function getCountryInformationAcquirer(): CountryInformationAcquirerInterface
        {
            return $this->_countryInformationAcquirer;
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
    }
?>