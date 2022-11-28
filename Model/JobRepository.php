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

    use Hippiemonkeys\ShippingTaxydromiki\Exception\NoSuchEntityException,
        Hippiemonkeys\ShippingTaxydromiki\Api\JobRepositoryInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterfaceFactory,
        Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel\Job as ResourceModel;

    class JobRepository
    implements JobRepositoryInterface
    {
        /**
         * Constructor
         *
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel\Job $resourceModel
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterfaceFactory $jobFactory
         */
        public function __construct(
            ResourceModel $resourceModel,
            JobInterfaceFactory $jobFactory
        )
        {
            $this->_resourceModel   = $resourceModel;
            $this->_jobFactory      = $jobFactory;
        }

        /**
         * @inheritdoc
         *
         * @throws \Hippiemonkeys\ShippingTaxydromiki\Exception\NoSuchEntityException
         */
        public function getById($id) : JobInterface
        {
            $job = $this->getJobFactory()->create();
            $this->getResourceModel()->load($job, $id, ResourceModel::FIELD_ID);
            if (!$job->getId())
            {
                throw new NoSuchEntityException(
                    __('The Job with id "%1" that was requested doesn\'t exist. Verify the job and try again', $id)
                );
            }
            return $job;
        }

        /**
         * @inheritdoc
         *
         * @throws \Hippiemonkeys\ShippingTaxydromiki\Exception\NoSuchEntityException
         */
        public function getByJobId(int $jobId) : JobInterface
        {
            $job = $this->getJobFactory()->create();
            $this->getResourceModel()->load($job, $jobId, ResourceModel::FIELD_JOB_ID);
            if (!$job->getId())
            {
                throw new NoSuchEntityException(
                    __('The Job with Job ID "%1" that was requested doesn\'t exist. Verify the job and try again', $id)
                );
            }
            return $job;
        }

        /**
         * @inheritdoc
         */
        public function getByVoucher(string $voucher) : JobInterface
        {
            $job = $this->getJobFactory()->create();
            $this->getResourceModel()->load($job, $voucher, ResourceModel::FIELD_VOUCHER);
            if (!$job->getId())
            {
                throw new NoSuchEntityException(
                    __('The Job with Voucher Code "%1" that was requested doesn\'t exist. Verify the job and try again', $voucher)
                );
            }
            return $job;
        }

        /**
         * @inheritdoc
         */
        public function save(JobInterface $job) : JobInterface
        {
            $this->getResourceModel()->save($job);
            return $job;
        }

        /**
         * @inheritdoc
         */
        public function delete(JobInterface $job) : bool
        {
            $this->getResourceModel()->delete($job);
            return $job->isDeleted();
        }

        /**
         * Resource Model property
         *
         * @access private
         *
         * @var Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel\Job $_resourceModel
         */
        private $_resourceModel;

        /**
         * Gets Resource Model
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel\Job
         */
        protected function getResourceModel(): ResourceModel
        {
            return $this->_resourceModel;
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
    }
?>