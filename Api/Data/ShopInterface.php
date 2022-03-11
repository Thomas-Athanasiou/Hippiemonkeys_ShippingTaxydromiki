<?php
    /**
     * @author Thomas Athanasiou at Hippiemonkeys | @Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys (https://hippiemonkeys.com)
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Api\Data;

    interface ShopInterface
    {
        /**
         * Gets ID
         *
         * @api
         *
         * @return mixed
         */
        function getId();

        /**
         * Sets ID
         *
         * @api
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
         *
         * @return string
         */
        function getCode(): string;

        /**
         * Sets Code
         *
         * @api
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
         *
         * @return string
         */
        function getCode2(): string;

        /**
         * Sets Code 2
         *
         * @api
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
         *
         * @return string
         */
        function getName(): string;

        /**
         * Sets Name
         *
         * @api
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
         *
         * @return string
         */
        function getState(): string;

        /**
         * Sets State
         *
         * @api
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
         *
         * @return string
         */
        function getCity(): string;

        /**
         * Sets City
         *
         * @api
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
         *
         * @return string
         */
        function getAddress(): string;

        /**
         * Sets Address
         *
         * @api
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
         *
         * @return string
         */
        function getTelephone(): string;

        /**
         * Sets Telephone
         *
         * @api
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
         *
         * @return string
         */
        function getCountry(): string;

        /**
         * Sets Country
         *
         * @api
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
         *
         * @return string
         */
        function getZip(): string;

        /**
         * Sets Zip
         *
         * @api
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
         *
         * @return string
         */
        function getEmail(): string;

        /**
         * Sets Email
         *
         * @api
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
         *
         * @return float
         */
        function getLatitude(): float;

        /**
         * Sets Latitude
         *
         * @api
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
         *
         * @return float
         */
        function getLongitude(): float;

        /**
         * Sets Longitude
         *
         * @api
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
         *
         * @return bool
         */
        function getSubshop(): bool;

        /**
         * Sets Subshop
         *
         * @api
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
         *
         * @return bool
         */
        function getActive(): bool;

        /**
         * Sets Active
         *
         * @api
         *
         * @param bool
         *
         * @return \this
         */
        function setActive(bool $active): ShopInterface;
    }
?>