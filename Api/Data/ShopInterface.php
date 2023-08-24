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

    namespace Hippiemonkeys\ShippingTaxydromiki\Api\Data;

    use Hippiemonkeys\Core\Api\Data\ModelInterface;

    interface ShopInterface
    extends ModelInterface
    {
        /**
         * Sets ID
         *
         * @api
         * @access public
         *
         * @param mixed
         *
         * @return \this
         */
        function setId($id);

        /**
         * Gets Code
         *
         * @api
         * @access public
         *
         * @return string
         */
        function getCode(): string;

        /**
         * Sets Code
         *
         * @api
         * @access public
         *
         * @param string
         *
         * @return \this
         */
        function setCode(string $code): ShopInterface;

        /**
         * Gets Code 2
         *
         * @api
         * @access public
         *
         * @return string
         */
        function getCode2(): string;

        /**
         * Sets Code 2
         *
         * @api
         * @access public
         *
         * @param string
         *
         * @return \this
         */
        function setCode2(string $code2): ShopInterface;

        /**
         * Gets Name
         *
         * @api
         * @access public
         *
         * @return string
         */
        function getName(): string;

        /**
         * Sets Name
         *
         * @api
         * @access public
         *
         * @param string
         *
         * @return \this
         */
        function setName(string $name): ShopInterface;

        /**
         * Gets State
         *
         * @api
         * @access public
         *
         * @return string
         */
        function getState(): string;

        /**
         * Sets State
         *
         * @api
         * @access public
         *
         * @param string
         *
         * @return \this
         */
        function setState(string $state): ShopInterface;

        /**
         * Gets City
         *
         * @api
         * @access public
         *
         * @return string
         */
        function getCity(): string;

        /**
         * Sets City
         *
         * @api
         * @access public
         *
         * @param string
         *
         * @return \this
         */
        function setCity(string $city): ShopInterface;

        /**
         * Gets Address
         *
         * @api
         * @access public
         *
         * @return string
         */
        function getAddress(): string;

        /**
         * Sets Address
         *
         * @api
         * @access public
         *
         * @param string
         *
         * @return \this
         */
        function setAddress(string $address): ShopInterface;

        /**
         * Gets Telephone
         *
         * @api
         * @access public
         *
         * @return string
         */
        function getTelephone(): string;

        /**
         * Sets Telephone
         *
         * @api
         * @access public
         *
         * @param string
         *
         * @return \this
         */
        function setTelephone(string $telephone): ShopInterface;

        /**
         * Gets Country
         *
         * @api
         * @access public
         *
         * @return string
         */
        function getCountry(): string;

        /**
         * Sets Country
         *
         * @api
         * @access public
         *
         * @param string
         *
         * @return \this
         */
        function setCountry(string $country): ShopInterface;

        /**
         * Gets Zip
         *
         * @api
         * @access public
         *
         * @return string
         */
        function getZip(): string;

        /**
         * Sets Zip
         *
         * @api
         * @access public
         *
         * @param string
         *
         * @return \this
         */
        function setZip(string $zip): ShopInterface;

        /**
         * Gets Email
         *
         * @api
         * @access public
         *
         * @return string
         */
        function getEmail(): string;

        /**
         * Sets Email
         *
         * @api
         * @access public
         *
         * @param string
         *
         * @return \this
         */
        function setEmail(string $email): ShopInterface;

        /**
         * Gets Latitude
         *
         * @api
         * @access public
         *
         * @return float
         */
        function getLatitude(): float;

        /**
         * Sets Latitude
         *
         * @api
         * @access public
         *
         * @param float
         *
         * @return \this
         */
        function setLatitude(float $latitude): ShopInterface;

        /**
         * Gets Longitude
         *
         * @api
         * @access public
         *
         * @return float
         */
        function getLongitude(): float;

        /**
         * Sets Longitude
         *
         * @api
         * @access public
         *
         * @param float
         *
         * @return \this
         */
        function setLongitude(float $Longitude): ShopInterface;

        /**
         * Gets Subshop
         *
         * @api
         * @access public
         *
         * @return bool
         */
        function getSubshop(): bool;

        /**
         * Sets Subshop
         *
         * @api
         * @access public
         *
         * @param bool
         *
         * @return \this
         */
        function setSubshop(bool $subshop): ShopInterface;

        /**
         * Gets Active
         *
         * @api
         * @access public
         *
         * @return bool
         */
        function getActive(): bool;

        /**
         * Sets Active
         *
         * @api
         * @access public
         *
         * @param bool
         *
         * @return \this
         */
        function setActive(bool $active): ShopInterface;
    }
?>