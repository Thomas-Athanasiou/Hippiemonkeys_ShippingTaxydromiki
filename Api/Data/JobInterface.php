<?php
    /**
     * @author Thomas Athanasiou at Hippiemonkeys
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
         * @return mixed
         */
        function getId();

        /**
         * Sets Id
         *
         * @param mixed $jobId
         *
         * @return \this
         */
        function setId($id);

        /**
         * Gets Job Id
         *
         * @return int
         */
        function getJobId() : int;

        /**
         * Sets Job Id
         *
         * @param int $jobId
         *
         * @return \this
         */
        function setJobId(int $jobId): JobInterface;

        /**
         * Gets Voucher
         *
         * @return string
         */
        function getVoucher() : string;

        /**
         * Sets Voucher
         *
         * @param string $voucher
         *
         * @return \this
         */
        function setVoucher(string $voucher): JobInterface;

        /**
         * Gets Canceled condition
         *
         * @return bool
         */
        function getCanceled() : bool;

        /**
         * Sets Canceled condition
         *
         * @param bool $canceled
         *
         * @return \this
         */
        function setCanceled(bool $canceled): JobInterface;

        /**
         * Gets Status
         *
         * @return int
         */
        function getStatus() : int;

        /**
         * Sets Status
         *
         * @param int $status
         *
         * @return \this
         */
        function setStatus(int $status): JobInterface;
    }
?>