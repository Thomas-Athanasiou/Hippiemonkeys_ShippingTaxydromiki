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

    namespace Hippiemonkeys\ShippingTaxydromiki\Model;

    use Magento\Framework\Api\SearchCriteriaBuilder,
        Hippiemonkeys\Core\Api\Helper\ConfigInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface,
        Hippiemonkeys\ShippingTaxydromiki\Model\Spi\JobResourceInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\JobRepositoryInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\JobManagementInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface;

    class JobManagement
    implements JobManagementInterface
    {
        /**
         * Constructor
         *
         * @access public
         *
         * @param \Hippiemonkeys\Core\Api\Helper\ConfigInterface $config
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface $carrier
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\JobRepositoryInterface $jobRepository
         * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
         * @param string[] $statusMap
         */
        public function __construct(
            ConfigInterface $config,
            CarrierInterface $carrier,
            JobRepositoryInterface $jobRepository,
            SearchCriteriaBuilder $searchCriteriaBuilder,
            array $statusMap
        )
        {
            $this->_config = $config;
            $this->_carrier = $carrier;
            $this->_jobRepository = $jobRepository;
            $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
            $this->_statusMap = $statusMap;
        }

        /**
         * @inheritdoc
         */
        public function processJob(JobInterface $job): void
        {
            $processJobFromGetVoucherJobResult = $this->processJobFromGetVoucherJob($job);
            $processJobFromTrackAndTraceResult = $this->processJobFromTrackAndTrace($job);
            if($processJobFromGetVoucherJobResult || $processJobFromTrackAndTraceResult)
            {
                $this->getJobRepository()->save($job);
            }
        }

        /**
         * Updates persistent jobs from the external GetVoucherJob carrier service
         *
         * @access private
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface $job
         *
         * @return bool
         */
        private function processJobFromGetVoucherJob(JobInterface $job): bool
        {
            $isCanceledUpdated = false;
            $isClosedUpdated = false;

            $getVoucherJobResult = $this->getCarrier()->getVoucherJob($job->getJobId())->GetVoucherJobResult ?? null;
            if(\is_object($getVoucherJobResult) && ($getVoucherJobResult->Result ?? CarrierInterface::RESULT_CODE_INVALID) === CarrierInterface::RESULT_CODE_SUCCESS)
            {
                $isCanceled = $getVoucherJobResult->IsCanceled ?? null;
                $isClosed = $getVoucherJobResult->IsClosed ?? null;

                $isCanceledUpdated = \is_bool($isCanceled) && $job->getCanceled() !== $isCanceled;
                $isClosedUpdated = \is_bool($isClosed) && $job->getClosed() !== $isClosed;

                if($isCanceledUpdated)
                {
                    $job->setCanceled($isCanceled);
                }
                if($isClosedUpdated)
                {
                    $job->setClosed($isClosed);
                }
            }

            return $isClosedUpdated || $isCanceledUpdated;
        }

        /**
         * Updates persistent jobs from the external TrackAndTrace carrier service
         *
         * @access private
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface $job
         *
         * @return bool
         */
        private function processJobFromTrackAndTrace(JobInterface $job): bool
        {
            $statusChanged = false;

            $trackAndTraceResult = $this->getCarrier()->trackAndTrace($job->getVoucher(), $this->getSoapLanguage())->TrackAndTraceResult ?? null;
            if($trackAndTraceResult && ($trackAndTraceResult->Result ?? CarrierInterface::RESULT_CODE_INVALID) === CarrierInterface::RESULT_CODE_SUCCESS)
            {
                $checkpoints = $trackAndTraceResult->Checkpoints ?? [];
                if(isset($checkpoints->Checkpoint) && is_array($checkpoints->Checkpoint) && count($checkpoints->Checkpoint))
                {
                    $checkpoints = $checkpoints->Checkpoint;
                }

                $genikiStatus = null;

                foreach((array) $checkpoints as $checkpoint)
                {
                    $checkpointStatus = $checkpoint->Status ?? null;
                    if($checkpointStatus)
                    {
                        $genikiStatus = $checkpointStatus;
                    }
                }

                if($genikiStatus)
                {
                    $statusMap = $this->getStatusMap();
                    if(isset($statusMap[$genikiStatus]))
                    {
                        $status = (int) $statusMap[$genikiStatus];
                        $statusChanged = $job->getStatus() !== $status;
                        if($statusChanged)
                        {
                            $job->setStatus($status);
                        }
                    }
                }
            }

            return $statusChanged;
        }

        /**
         * @inheritdoc
         */
        public function updateJobs(int $limit): void
        {
            $searchCriteriaBuilder = $this->getSearchCriteriaBuilder();
            $searchCriteriaBuilder->setPageSize($limit);
            foreach($this->getJobRepository()->getList($searchCriteriaBuilder->create())->getItems() as $job)
            {
                $this->processJob($job);
            }
        }

        /**
         * @inheritdoc
         */
        public function updateJobsWithStatus(int $status, int $limit): void
        {
            $searchCriteriaBuilder = $this->getSearchCriteriaBuilder();
            $searchCriteriaBuilder->setPageSize($limit);
            $searchCriteriaBuilder->addFilter(JobResourceInterface::FIELD_STATUS, $status, 'eq');
            $searchCriteria = $searchCriteriaBuilder->create();
            $searchCriteriaBuilder->setFilterGroups([]);

            foreach($this->getJobRepository()->getList($searchCriteria)->getItems() as $job)
            {
                $this->processJob($job);
            }
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
         * Gets Logger
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
         * Carrier property
         *
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface
         */
        private $_carrier;

        /**
         * Gets Carrier
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface
         */
        protected function getCarrier(): CarrierInterface
        {
            return $this->_carrier;
        }

        /**
         * Job Repository property
         *
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\JobRepositoryInterface
         */
        private $_jobRepository;

        /**
         * Gets Job Repository
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\JobRepositoryInterface
         */
        protected function getJobRepository(): JobRepositoryInterface
        {
            return $this->_jobRepository;
        }

        /**
         * Status Map property
         *
         * @access private
         *
         * @var string[] $_statusMap
         */
        private $_statusMap;

        /**
         * Gets Status Map
         *
         * @access protected
         *
         * @return string[]
         */
        protected function getStatusMap(): array
        {
            return $this->_statusMap;
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
            return $this->getConfig()->getData('soap_language');
        }

        /**
         * Search Criteria Builder property
         *
         * @access private
         *
         * @var \Magento\Framework\Api\SearchCriteriaBuilder $_searchCriteriaBuilder
         */
        private $_searchCriteriaBuilder;

        /**
         * Gets Search Criteria Builder
         *
         * @access protected
         *
         * @return \Magento\Framework\Api\SearchCriteriaBuilder
         */
        protected function getSearchCriteriaBuilder(): SearchCriteriaBuilder
        {
            return $this->_searchCriteriaBuilder;
        }
    }
?>