<?php
    /**
     * @Thomas-Athanasiou
     *
     * @author Thomas Athanasiou at Hippiemonkeys
     * @link https://github.com/Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys (https://hippiemonkeys.com)
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Model;

    use Magento\Framework\Model\AbstractModel,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface,
        Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel\Job as ResourceModel;

    class Job
    extends AbstractModel
    implements JobInterface
    {
        /**
         * @inheritdoc
         */
        protected function _construct()
        {
            $this->_init(ResourceModel::class);
        }

        /**
         * @inheritdoc
         */
        public function getId()
        {
            return $this->getData(ResourceModel::FIELD_ID);
        }

        /**
         * @inheritdoc
         */
        public function setId($id)
        {
            return $this->setData(ResourceModel::FIELD_ID, $id);
        }

        /**
         * @inheritdoc
         */
        public function getJobId(): int
        {
            return $this->getData(ResourceModel::FIELD_JOB_ID);
        }

        /**
         * @inheritdoc
         */
        public function setJobId(int $jobId): Job
        {
            return $this->setData(ResourceModel::FIELD_JOB_ID, $jobId);
        }

        /**
         * @inheritdoc
         */
        public function getVoucher(): string
        {
            return $this->getData(ResourceModel::FIELD_VOUCHER);
        }

        /**
         * @inheritdoc
         */
        public function setVoucher(string $voucher): Job
        {
            return $this->setData(ResourceModel::FIELD_VOUCHER, $voucher);
        }

        /**
         * @inheritdoc
         */
        public function getCanceled(): bool
        {
            return (bool) $this->getData(ResourceModel::FIELD_CANCELED);
        }

        /**
         * @inheritdoc
         */
        public function setCanceled(bool $canceled): Job
        {
            return $this->setData(ResourceModel::FIELD_CANCELED, (string) $canceled);
        }

        /**
         * @inheritdoc
         */
        function getStatus() : int
        {
            return (int) $this->getData(ResourceModel::FIELD_STATUS);
        }

        /**
         * @inheritdoc
         */
        function setStatus(int $status): JobInterface
        {
            return $this->setData(ResourceModel::FIELD_STATUS, (string) $status);
        }
    }
?>