<?php
    /**
     * @Thomas-Athanasiou
     *
     * @author Thomas Athanasiou at Hippiemonkeys
     * @link https://github.com/Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys (https://hippiemonkeys.com)
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Api\Data;

    use Magento\Framework\Api\SearchResultsInterface;

    interface ShopSearchResultInterface
    extends SearchResultsInterface
    {
        /**
         * Gets collection items
         *
         * @api
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterface[] Array of collection items
         */
        public function getItems();

        /**
         * Sets collection line items
         *
         * @api
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterface[] $shops
         *
         * @return $this
         */
        public function setItems(array $shops);
    }
?>