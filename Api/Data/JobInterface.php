<?php
    /**
     * @author Thomas Athanasiou at Hippiemonkeys | @Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys (https://hippiemonkeys.com)
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Api\Data;

    interface JobInterface
    {
        const
            STATUS_NONE         = 0,
            STATUS_INTRANSIT    = 1,
            STATUS_INSHOP       = 2,
            STATUS_DELIVERED    = 3,
            STATUS_CANCELED     = 4,
            STATUS_RETURNED     = 5,
            STATUS_PENDING      = 6;

        /**
         * Gets Id
         *
         * @api
         *
         * @return mixed
         */
        function getId();

        /**
         * Sets Id
         *
         * @api
         *
         * @param mixed $jobId
         *
         * @return \this
         */
        function setId($id);

        /**
         * Gets Job Id
         *
         * @api
         *
         * @return int
         */
        function getJobId() : int;

        /**
         * Sets Job Id
         *
         * @api
         *
         * @param int $jobId
         *
         * @return \this
         */
        function setJobId(int $jobId): JobInterface;

        /**
         * Gets Voucher
         *
         * @api
         *
         * @return string
         */
        function getVoucher() : string;

        /**
         * Sets Voucher
         *
         * @api
         *
         * @param string $voucher
         *
         * @return \this
         */
        function setVoucher(string $voucher): JobInterface;

        /**
         * Gets Canceled condition
         *
         * @api
         *
         * @return bool
         */
        function getCanceled() : bool;

        /**
         * Sets Canceled condition
         *
         * @api
         *
         * @param bool $canceled
         *
         * @return \this
         */
        function setCanceled(bool $canceled): JobInterface;

        /**
         * Gets Status
         *
         * @api
         *
         * @return int
         */
        function getStatus() : int;

        /**
         * Sets Status
         *
         * @api
         *
         * @param int $status
         *
         * @return \this
         */
        function setStatus(int $status): JobInterface;
    }
?>