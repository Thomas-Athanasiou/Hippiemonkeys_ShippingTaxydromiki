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

    namespace Hippiemonkeys\ShippingTaxydromiki\Model\Spi;

    use Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterface,
        Hippiemonkeys\Core\Model\Spi\ModelResourceInterface;

    /**
     * Shop Resource interface
     */
    interface ShopResourceInterface
    extends ModelResourceInterface
    {
        const
            FIELD_CODE = 'code',
            FIELD_CODE2 = 'code2',
            FIELD_NAME = 'name',
            FIELD_STATE = 'state',
            FIELD_CITY = 'city',
            FIELD_ADDRESS = 'address',
            FIELD_TELEPHONE = 'telephone',
            FIELD_COUNTRY = 'country',
            FIELD_ZIP = 'zip',
            FIELD_EMAIL = 'email',
            FIELD_LONGITUDE = 'longitude',
            FIELD_LATITUDE = 'latitude',
            FIELD_SUBSHOP = 'subshop',
            FIELD_ACTIVE = 'active';

        /**
         * Save Shop data
         *
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterface $shop
         *
         * @return $this
         */
        function saveShop(ShopInterface $shop): ShopResourceInterface;

        /**
         * Load a Shop by Id
         *
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterface $shop
         * @param mixed $id
         *
         * @return $this
         */
        function loadShopById(ShopInterface $object, $id): ShopResourceInterface;

        /**
         * Delete the Shop
         *
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterface $shop
         *
         * @return bool
         */
        function deleteShop(ShopInterface $shop): bool;
    }
?>