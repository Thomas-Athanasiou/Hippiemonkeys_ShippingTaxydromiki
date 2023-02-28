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
        Hippiemonkeys\ShippingTaxydromiki\Api\JobRepositoryInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\JobManagementInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\TaxydromikiInterface;

    class JobManagement
    implements JobManagementInterface
    {
        /**
         * Constructor
         *
         * @access public
         *
         * @param \Hippiemonkeys\Core\Api\Helper\ConfigInterface $config
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\TaxydromikiInterface $taxydromiki
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\JobRepositoryInterface $jobRepository
         * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
         * @param string[] $statusMap
         */
        public function __construct(
            ConfigInterface $config,
            TaxydromikiInterface $taxydromiki,
            JobRepositoryInterface $jobRepository,
            SearchCriteriaBuilder $searchCriteriaBuilder
        )
        {
            $this->_config = $config;
            $this->_taxydromiki = $taxydromiki;
            $this->_jobRepository = $jobRepository;
            $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        }

        /**
         * {@inheritdoc}
         */
        public function processJob(JobInterface $job): void
        {
            $processJobFromGetVoucherJobResult = $this->processJobFromGetVoucherJob($job);
            if($processJobFromGetVoucherJobResult)
            {
                $this->getJobRepository()->save($job);
            }
        }

        /**
         * Updates persistent jobs from the external GetVoucherJob taxydromiki service
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

            $getVoucherJobResult = $this->getTaxydromiki()->getVoucherJob($job->getJobId())->GetVoucherJobResult ?? null;
            if(\is_object($getVoucherJobResult) && ($getVoucherJobResult->Result ?? TaxydromikiInterface::RESULT_CODE_INVALID) === TaxydromikiInterface::RESULT_CODE_SUCCESS)
            {
                $isCanceled = (bool) ($getVoucherJobResult->IsCanceled ?? false);
                $isClosed = (bool) ($getVoucherJobResult->IsClosed ?? false);

                $isCanceledUpdated = $job->getCanceled() !== $isCanceled;
                $isClosedUpdated = $job->getClosed() !== $isClosed;

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
         * Taxydromiki property
         *
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\TaxydromikiInterface
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