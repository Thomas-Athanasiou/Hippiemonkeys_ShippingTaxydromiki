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

    use Magento\Framework\Api\SearchCriteriaInterface,
        Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface,
        Hippiemonkeys\ShippingTaxydromiki\Exception\NoSuchEntityException,
        Hippiemonkeys\ShippingTaxydromiki\Api\JobRepositoryInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterfaceFactory,
        Hippiemonkeys\ShippingTaxydromiki\Model\Spi\JobResourceInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobSearchResultInterface as SearchResultInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobSearchResultInterfaceFactory as SearchResultInterfaceFactory;

    class JobRepository
    implements JobRepositoryInterface
    {
        /**
         * Id Cache property
         *
         * @access protected
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface[] $_idCache
         */
        protected $_idCache = [];

        /**
         * Voucher Cache property
         *
         * @access protected
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface[] $_voucherCache
         */
        protected $_voucherCache = [];

        /**
         * Job Id Cache property
         *
         * @access protected
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface[] $_jobIdCache
         */
        protected $_jobIdCache = [];


        /**
         * Constructor
         *
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Model\Spi\JobResourceInterface $jobResource
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterfaceFactory $jobFactory
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobSearchResultInterfaceFactory $searchResultFactory
         * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
         */
        public function __construct(
            JobResourceInterface $jobResource,
            JobInterfaceFactory $jobFactory,
            SearchResultInterfaceFactory $searchResultFactory,
            CollectionProcessorInterface $collectionProcessor
        )
        {
            $this->_jobResource = $jobResource;
            $this->_jobFactory = $jobFactory;
            $this->_searchResultFactory = $searchResultFactory;
            $this->_collectionProcessor = $collectionProcessor;
        }

        /**
         * {@inheritdoc}
         *
         * @throws \Hippiemonkeys\ShippingTaxydromiki\Exception\NoSuchEntityException
         */
        public function getById($id) : JobInterface
        {
            $job = $this->_idCache[$id] ?? null;
            if($job === null)
            {
                $job = $this->getJobFactory()->create();
                $this->getJobResource()->loadJobById($job, $id);
                if ($job->getId() === null)
                {
                    throw new NoSuchEntityException(
                        __('The Job with id "%1" that was requested doesn\'t exist. Verify the job and try again', $id)
                    );
                }
                else
                {
                    $this->_idCache[$id] = $job;
                    $this->_voucherCache[$job->getVoucher()] = $job;
                    $this->_jobIdCache[$job->getJobId()] = $job;
                }
            }
            return $job;
        }

        /**
         * {@inheritdoc}
         *
         * @throws \Hippiemonkeys\ShippingTaxydromiki\Exception\NoSuchEntityException
         */
        public function getByJobId(int $jobId) : JobInterface
        {
            $job = $this->_jobIdCache[$jobId] ?? null;
            if($job === null)
            {
                $job = $this->getJobFactory()->create();
                $this->getJobResource()->loadJobByJobId($job, $jobId);
                $id = $job->getId();
                if ($id === null)
                {
                    throw new NoSuchEntityException(
                        __('The Job with Job ID "%1" that was requested doesn\'t exist. Verify the job and try again', $id)
                    );
                }
                else
                {
                    $this->_idCache[$id] = $job;
                    $this->_voucherCache[$job->getVoucher()] = $job;
                    $this->_jobIdCache[$jobId] = $job;
                }
            }
            return $job;
        }

        /**
         * {@inheritdoc}
         *
         * @throws \Hippiemonkeys\ShippingTaxydromiki\Exception\NoSuchEntityException
         */
        public function getByVoucher(string $voucher) : JobInterface
        {
            $job = $this->_voucherCache[$voucher] ?? null;
            if($job === null)
            {
                $job = $this->getJobFactory()->create();
                $this->getJobResource()->loadJobByVoucher($job, $voucher);
                $id = $job->getId();
                if ($id === null)
                {
                    throw new NoSuchEntityException(
                        __('The Job with Voucher "%1" that was requested doesn\'t exist. Verify the Job and try again', $voucher)
                    );
                }
                else
                {
                    $this->_idCache[$id] = $job;
                    $this->_voucherCache[$voucher] = $job;
                    $this->_jobIdCache[$job->getJobId()] = $job;
                }
            }
            return $job;
        }

        /**
         * {@inheritdoc}
         */
        public function getList(SearchCriteriaInterface $searchCriteria): SearchResultInterface
        {
            $searchResult = $this->getSearchResultFactory()->create();
            $searchResult->setSearchCriteria($searchCriteria);
            $this->getCollectionProcessor()->process($searchCriteria, $searchResult);
            return $searchResult;
        }

        /**
         * {@inheritdoc}
         */
        public function save(JobInterface $job) : JobInterface
        {
            $this->_idCache[$job->getId()] = $job;
            $this->_jobIdCache[$job->getJobId()] = $job;
            $this->_voucherCache[$job->getVoucher()] = $job;
            $this->getJobResource()->saveJob($job);
            return $job;
        }

        /**
         * {@inheritdoc}
         */
        public function delete(JobInterface $job) : bool
        {
            unset($this->_idCache[$job->getId()]);
            unset($this->_jobIdCache[$job->getJobId()]);
            unset($this->_voucherCache[$job->getVoucher()]);
            return $this->getJobResource()->deleteJob($job);
        }

        /**
         * Job Resource property
         *
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Model\Spi\JobResourceInterface $_jobResource
         */
        private $_jobResource;

        /**
         * Gets Job Resource
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Model\Spi\JobResourceInterface
         */
        protected function getJobResource(): JobResourceInterface
        {
            return $this->_jobResource;
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
         * Collection Processor property
         *
         * @access private
         *
         * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $_collectionProcessor
         */
        private $_collectionProcessor;

        /**
         * Gets Collection Processor
         *
         * @access protected
         *
         * @return \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
         */
        protected function getCollectionProcessor() : CollectionProcessorInterface
        {
            return $this->_collectionProcessor;
        }

        /**
         * Search Result Factory property
         *
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobSearchResultInterfaceFactory $_searchResultFactory
         */
        private $_searchResultFactory;

        /**
         * Gets Search Result Factory
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobSearchResultInterfaceFactory
         */
        protected function getSearchResultFactory(): SearchResultInterfaceFactory
        {
            return $this->_searchResultFactory;
        }
    }
?>