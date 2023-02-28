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

    use Hippiemonkeys\Core\Api\Data\ModelInterface;

    interface JobInterface
    extends ModelInterface
    {
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
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface
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
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface
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
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface
         */
        function setCanceled(bool $canceled): JobInterface;

        /**
         * Gets Closed condition
         *
         * @api
         * @access public
         *
         * @return bool
         */
        function getClosed() : bool;

        /**
         * Sets Closed condition
         *
         * @api
         * @access public
         *
         * @param bool $closed
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface
         */
        function setClosed(bool $closed): JobInterface;
    }
?>