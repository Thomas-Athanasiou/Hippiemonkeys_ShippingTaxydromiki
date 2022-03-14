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

    namespace Hippiemonkeys\ShippingTaxydromiki\Api;

    use Magento\Framework\Api\SearchCriteriaInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopSearchResultInterface;

    interface ShopRepositoryInterface
    {
        /**
         * Gets Shop by ID
         *
         * @api
         *
         * @param mixed $id
         *
         * @return $this
         */
        function getById($id): ShopInterface;

        /**
         * Gets Shops List by search criteria provided
         *
         * @api
         *
         * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopSearchResultInterface
         */
        function getList(SearchCriteriaInterface $searchCriteria): ShopSearchResultInterface;

        /**
         * Deletes Shop
         *
         * @api
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterface $shop
         *
         * @return bool
         */
        function delete(ShopInterface $shop): bool;

        /**
         * Saves Shop
         *
         * @api
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterface $shop
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterface
         */
        function save(ShopInterface $shop): ShopInterface;
    }
?>