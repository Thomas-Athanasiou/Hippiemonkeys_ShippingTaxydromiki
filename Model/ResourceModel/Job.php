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

    namespace Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel;

    use Hippiemonkeys\Core\Model\ResourceModel\AbstractResource,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface,
        Hippiemonkeys\ShippingTaxydromiki\Model\Spi\JobResourceInterface;

    class Job
    extends AbstractResource
    implements JobResourceInterface
    {
        protected const
            TABLE_MAIN = 'hippiemonkeys_shippingtaxydromiki_job';

        /**
         * {{@inheritdoc}}
         */
        protected function _construct()
        {
            $this->_init(static::TABLE_MAIN, static::FIELD_ID);
        }

        /**
         * {@inheritdoc}
         */
        public function saveJob(JobInterface $job): JobResourceInterface
        {
            return $this->saveModel($job);
        }

        /**
         * {@inheritdoc}
         */
        public function loadJobById(JobInterface $job, $id): JobResourceInterface
        {
            return $this->loadModelById($job, $id);
        }

        /**
         * {@inheritdoc}
         */
        public function loadJobByJobId(JobInterface $job, int $jobId): JobResourceInterface
        {
            return $this->loadModel($job, $jobId, static::FIELD_JOB_ID);
        }

        /**
         * {@inheritdoc}
         */
        public function loadJobByVoucher(JobInterface $job, string $voucher): JobResourceInterface
        {
            return $this->loadModel($job, $voucher, static::FIELD_VOUCHER);
        }

        /**
         * {@inheritdoc}
         */
        public function deleteJob(JobInterface $job): bool
        {
            return $this->deleteJob($job);
        }
    }
?>