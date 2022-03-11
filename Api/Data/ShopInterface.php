<?php
    /**
     * @author Thomas Athanasiou at Hippiemonkeys
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
         * @return mixed
         */
        function getId();

        /**
         * Sets ID
         *
         * @param mixed
         *
         * @return \this
         */
        function setId($id);

        /**
         * Gets Code
         *
         * @return string
         */
        function getCode(): string;

        /**
         * Sets Code
         *
         * @param string
         *
         * @return \this
         */
        function setCode(string $code): ShopInterface;

        /**
         * Gets Code 2
         *
         * @return string
         */
        function getCode2(): string;

        /**
         * Sets Code 2
         *
         * @param string
         *
         * @return \this
         */
        function setCode2(string $code2): ShopInterface;

        /**
         * Gets Name
         *
         * @return string
         */
        function getName(): string;

        /**
         * Sets Name
         *
         * @param string
         *
         * @return \this
         */
        function setName(string $name): ShopInterface;

        /**
         * Gets State
         *
         * @return string
         */
        function getState(): string;

        /**
         * Sets State
         *
         * @param string
         *
         * @return \this
         */
        function setState(string $state): ShopInterface;

        /**
         * Gets City
         *
         * @return string
         */
        function getCity(): string;

        /**
         * Sets City
         *
         * @param string
         *
         * @return \this
         */
        function setCity(string $city): ShopInterface;

        /**
         * Gets Address
         *
         * @return string
         */
        function getAddress(): string;

        /**
         * Sets Address
         *
         * @param string
         *
         * @return \this
         */
        function setAddress(string $address): ShopInterface;

        /**
         * Gets Telephone
         *
         * @return string
         */
        function getTelephone(): string;

        /**
         * Sets Telephone
         *
         * @param string
         *
         * @return \this
         */
        function setTelephone(string $telephone): ShopInterface;

        /**
         * Gets Country
         *
         * @return string
         */
        function getCountry(): string;

        /**
         * Sets Country
         *
         * @param string
         *
         * @return \this
         */
        function setCountry(string $country): ShopInterface;

        /**
         * Gets Zip
         *
         * @return string
         */
        function getZip(): string;

        /**
         * Sets Zip
         *
         * @param string
         *
         * @return \this
         */
        function setZip(string $zip): ShopInterface;

        /**
         * Gets Email
         *
         * @return string
         */
        function getEmail(): string;

        /**
         * Sets Email
         *
         * @param string
         *
         * @return \this
         */
        function setEmail(string $email): ShopInterface;

        /**
         * Gets Latitude
         *
         * @return float
         */
        function getLatitude(): float;

        /**
         * Sets Latitude
         *
         * @param float
         *
         * @return \this
         */
        function setLatitude(float $latitude): ShopInterface;

        /**
         * Gets Longitude
         *
         * @return float
         */
        function getLongitude(): float;

        /**
         * Sets Longitude
         *
         * @param float
         *
         * @return \this
         */
        function setLongitude(float $Longitude): ShopInterface;

        /**
         * Gets Subshop
         *
         * @return bool
         */
        function getSubshop(): bool;

        /**
         * Sets Subshop
         *
         * @param bool
         *
         * @return \this
         */
        function setSubshop(bool $subshop): ShopInterface;

        /**
         * Gets Active
         *
         * @return bool
         */
        function getActive(): bool;

        /**
         * Sets Active
         *
         * @param bool
         *
         * @return \this
         */
        function setActive(bool $active): ShopInterface;
    }
?>