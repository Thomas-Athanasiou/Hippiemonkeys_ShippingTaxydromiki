<?php
    /**
     * @author Thomas Athanasiou at Hippiemonkeys | @Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys (https://hippiemonkeys.com)
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Api;

    use Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface;

    interface JobRepositoryInterface
    {
        /**
         * Gets Job by Id
         *
         * @api
         *
         * @param mixed $id
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface
         */
        function getById($id): JobInterface;

        /**
         * Gets Job by Job Id
         *
         * @api
         *
         * @param int $jobId
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface
         */
        function getByJobId(int $jobId): JobInterface;

        /**
         * Gets Job by voucher
         *
         * @api
         *
         * @param string $voucher
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface
         */
        function getByVoucher(string $voucher): JobInterface;

        /**
         * Deletes Job
         *
         * @api
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface $job
         *
         * @return bool
         */
        function delete(JobInterface $job): bool;

        /**
         * Saves Job
         *
         * @api
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface $job
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface
         */
        function save(JobInterface $job): JobInterface;
    }
?>