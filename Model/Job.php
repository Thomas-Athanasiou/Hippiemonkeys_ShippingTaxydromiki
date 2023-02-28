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

    use Hippiemonkeys\Core\Model\AbstractModel,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface,
        Hippiemonkeys\ShippingTaxydromiki\Model\Spi\JobResourceInterface;

    class Job
    extends AbstractModel
    implements JobInterface
    {
        /**
         * {@inheritdoc}
         */
        public function setId($id)
        {
            return $this->setData(JobResourceInterface::FIELD_ID, $id);
        }

        /**
         * {@inheritdoc}
         */
        public function getJobId(): int
        {
            return (int) $this->getData(JobResourceInterface::FIELD_JOB_ID);
        }

        /**
         * {@inheritdoc}
         */
        public function setJobId(int $jobId): Job
        {
            return $this->setData(JobResourceInterface::FIELD_JOB_ID, $jobId);
        }

        /**
         * {@inheritdoc}
         */
        public function getVoucher(): string
        {
            return $this->getData(JobResourceInterface::FIELD_VOUCHER);
        }

        /**
         * {@inheritdoc}
         */
        public function setVoucher(string $voucher): Job
        {
            return $this->setData(JobResourceInterface::FIELD_VOUCHER, $voucher);
        }

        /**
         * {@inheritdoc}
         */
        public function getCanceled(): bool
        {
            return (bool) $this->getData(JobResourceInterface::FIELD_CANCELED);
        }

        /**
         * {@inheritdoc}
         */
        public function setCanceled(bool $canceled): Job
        {
            return $this->setData(JobResourceInterface::FIELD_CANCELED, (string) $canceled);
        }

        /**
         * {@inheritdoc}
         */
        public function getClosed(): bool
        {
            return (bool) $this->getData(JobResourceInterface::FIELD_CLOSED);
        }

        /**
         * {@inheritdoc}
         */
        public function setClosed(bool $closed): Job
        {
            return $this->setData(JobResourceInterface::FIELD_CLOSED, (string) $closed);
        }
    }
?>