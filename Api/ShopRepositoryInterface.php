<?php
    /**
     * @author Thomas Athanasiou at Hippiemonkeys
     * @copyright Copyright (c) 2022 Hippiemonkeys (https://hippiemonkeys.com)
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Api;

    use Magento\Framework\Api\SearchCriteriaInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopSearchResultInterface;

    interface ShopRepositoryInterface
    {
        /**
         * Gets Shop by ID
         *
         * @param mixed $id
         *
         * @return $this
         */
        function getById($id): ShopInterface;

        /**
         * Gets Shops List by search criteria provided
         *
         * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopSearchResultInterface
         */
        function getList(SearchCriteriaInterface $searchCriteria): ShopSearchResultInterface;

        /**
         * Deletes Shop
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterface $shop
         *
         * @return bool
         */
        function delete(ShopInterface $shop): bool;

        /**
         * Saves Shop
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterface $shop
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterface
         */
        function save(ShopInterface $shop): ShopInterface;
    }
?>