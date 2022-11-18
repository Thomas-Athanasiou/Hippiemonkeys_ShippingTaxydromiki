<?php
    /**
     * @Thomas-Athanasiou
     *
     * @author Thomas Athanasiou at Hippiemonkeys
     * @link https://github.com/Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys Web Inteligence EE (https://hippiemonkeys.com)
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Helper\Taxydromiki;

    use Psr\Log\LoggerInterface,
        Magento\Framework\Api\SearchCriteriaBuilder,
        Hippiemonkeys\Core\Api\Helper\ConfigInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface,
        Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel\Job as JobResourceInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\JobManagementInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\JobRepositoryInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Helper\Taxydromiki\UpdateJobsInterface,
        Hippiemonkeys\ShippingTaxydromiki\Helper\Taxydromiki;

    class UpdateJobs
    extends Taxydromiki
    implements UpdateJobsInterface
    {
        /**
         * Constructor
         *
         * @access public
         *
         * @param \Psr\Log\LoggerInterface $logger
         * @param \Hippiemonkeys\Core\Api\Helper\ConfigInterface $config
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface $carrier
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\JobManagementInterface $jobManagement,
         * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
         * @param int $updateForStatus
         */
        public function __construct(
            LoggerInterface $logger,
            ConfigInterface $config,
            CarrierInterface $carrier,
            JobManagementInterface $jobManagement,
            JobRepositoryInterface $jobRepository,
            SearchCriteriaBuilder $searchCriteriaBuilder,
            int $updateForStatus
        )
        {
            parent::__construct($logger, $config, $carrier);
            $this->_jobManagement = $jobManagement;
            $this->_jobRepository = $jobRepository;
            $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        }

        /**
         * @inheritdoc
         */
        public function updateJobs(): void
        {
            $searchCriteriaBuilder = $this->getSearchCriteriaBuilder()->addFilter(JobResourceInterface::FIELD_STATUS, $this->getUpdateForStatus(), 'eq');
            $jobs = $this->getJobRepository()->getList($searchCriteriaBuilder->create())->getItems();
            $searchCriteriaBuilder->setFilterGroups([]);

            $jobManagement = $this->getJobManagement();
            foreach($jobs as $job)
            {
                $jobManagement->processJob($job);
            }
        }

        /**
         * Job Management property
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\JobManagementInterface
         */
        private $_jobManagement;

        /**
         * Gets Job Management
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\JobManagementInterface
         */
        protected function getJobManagement(): JobManagementInterface
        {
            return $this->_jobManagement;
        }

        /**
         * Job Repository property
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\JobRepositoryInterface
         */
        private $_jobRepository;

        /**
         * Gets Job Repository
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\JobRepositoryInterface
         */
        protected function getJobRepository(): JobRepositoryInterface
        {
            return $this->_jobRepository;
        }

        /**
         * Search Criteria Builder Factory property
         *
         * @access private
         *
         * @var \Magento\Framework\Api\SearchCriteriaBuilder $_updateForStatus
         */
        private $_searchCriteriaBuilder;

        /**
         * Gets Search Criteria Builder Factory
         *
         * @access protected
         *
         * @return \Magento\Framework\Api\SearchCriteriaBuilder
         */
        protected function getSearchCriteriaBuilder() : SearchCriteriaBuilder
        {
            return $this->_searchCriteriaBuilder;
        }

        /**
         * Update For Status property
         *
         * @var int $_updateForStatus
         */
        private $_updateForStatus;

        /**
         * Gets Update For Status
         *
         * @return int
         */
        protected function getUpdateForStatus(): int
        {
            return $this->_updateForStatus;
        }
    }
?>