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
         * @access public
         *
         * @return mixed
         */
        function getId();

        /**
         * Sets Id
         *
         * @api
         *
         * @access public
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
         * @access public
         *
         * @return int
         */
        function getJobId() : int;

        /**
         * Sets Job Id
         *
         * @api
         * @access public
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
         * @access public
         *
         * @return string
         */
        function getVoucher() : string;

        /**
         * Sets Voucher
         *
         * @api
         * @access public
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
         * @access public
         *
         * @return bool
         */
        function getCanceled() : bool;

        /**
         * Sets Canceled condition
         *
         * @api
         * @access public
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
         * @access public
         *
         * @return int
         */
        function getStatus() : int;

        /**
         * Sets Status
         *
         * @api
         * @access public
         *
         * @param int $status
         *
         * @return \this
         */
        function setStatus(int $status): JobInterface;
    }
?>