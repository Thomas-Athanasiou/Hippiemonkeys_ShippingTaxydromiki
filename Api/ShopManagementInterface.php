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

    namespace Hippiemonkeys\ShippingTaxydromiki\Api;

    interface ShopManagementInterface
    {
        /**
         * Saves shop provided by geniki to persistent storage
         *
         * @api
         * @access public
         *
         * @param object $soapShop
         */
        function saveShop(object $soapShop): void;

        /**
         * Saves shops provided by geniki to persistent storage
         *
         * @api
         * @access public
         *
         * @param object[] $soapShops
         */
        function saveShops(array $soapShops): void;

        /**
         * Cleans saved Shops that are not found in soap shops provided
         *
         * @api
         * @access public
         *
         * @param object[] $soapShops
         */
        function cleanPersistentShops(array $soapShops): void;

        /**
         * Updates persistent shops from the external carrier service
         *
         * @api
         * @access public
         */
        public function updateShops(): void;
    }
?>