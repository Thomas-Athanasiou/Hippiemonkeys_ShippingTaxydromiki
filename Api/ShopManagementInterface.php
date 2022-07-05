<?php
    /**
     * @Thomas-Athanasiou
     *
     * @author Thomas Athanasiou at Hippiemonkeys
     * @link https://github.com/Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys Web Inteligence EE (https://hippiemonkeys.com)
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
    }
?>