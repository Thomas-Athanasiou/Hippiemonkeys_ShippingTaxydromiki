<?php
    /**
     * @author Thomas Athanasiou at Hippiemonkeys | @Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys (https://hippiemonkeys.com)
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Api;

    interface ShopManagementInterface
    {

        /**
         * Saves shop provided by geniki to persistent storage
         *
         * @param object $soapShop
         */
        public function saveShop(object $soapShop): void;

        /**
         * Saves shops provided by geniki to persistent storage
         *
         * @param object[] $soapShops
         */
        public function saveShops(array $soapShops): void;

        /**
         * Cleans saved Shops that are not found in soap shops provided
         *
         * @param object[] $soapShops
         */
        public function cleanPersistentShops(array $soapShops): void;
    }
?>