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

    namespace Hippiemonkeys\ShippingTaxydromiki\Model\Spi;

    use Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface,
        Hippiemonkeys\Core\Model\Spi\ModelResourceInterface;

    /**
     * Job Resource interface
     */
    interface JobResourceInterface
    extends ModelResourceInterface
    {
        const
            FIELD_JOB_ID = 'job_id',
            FIELD_VOUCHER = 'voucher',
            FIELD_CANCELED = 'canceled',
            FIELD_CLOSED = 'closed',
            FIELD_STATUS = 'status';

        /**
         * Save Job data
         *
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface $job
         *
         * @return $this
         */
        function saveJob(JobInterface $job): JobResourceInterface;

        /**
         * Load a Job by Id
         *
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface $job
         * @param mixed $id
         *
         * @return $this
         */
        function loadJobById(JobInterface $object, $id): JobResourceInterface;

        /**
         * Load a Job by Job Id
         *
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface $job
         * @param int $jobId
         *
         * @return $this
         */
        function loadJobByJobId(JobInterface $object, int $jobId): JobResourceInterface;

        /**
         * Load a Job by Voucher
         *
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface $job
         * @param string $voucher
         *
         * @return $this
         */
        function loadJobByVoucher(JobInterface $object, string $voucher): JobResourceInterface;

        /**
         * Delete the Job
         *
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface $job
         *
         * @return bool
         */
        function deleteJob(JobInterface $job): bool;
    }
?>