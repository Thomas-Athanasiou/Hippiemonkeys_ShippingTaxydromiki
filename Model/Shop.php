<?php
    /**
     * @author Thomas Athanasiou at Hippiemonkeys | @Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys (https://hippiemonkeys.com)
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Model;

    use Magento\Framework\Model\AbstractModel,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterface,
        Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel\Shop as ResourceModel;

    class Shop
    extends AbstractModel
    implements ShopInterface
    {
        /**
         * @inheritdoc
         */
        protected function _construct()
        {
            $this->_init(ResourceModel::class);
        }

        /**
         * @inheritdoc
         */
        public function getId()
        {
            return $this->getData(ResourceModel::FIELD_ID);
        }

        /**
         * @inheritdoc
         */
        public function setId($id)
        {
            return $this->setData(ResourceModel::FIELD_ID, $id);
        }

        /**
         * @inheritdoc
         */
        public function getCode(): string
        {
            return $this->getData(ResourceModel::FIELD_CODE);
        }

        /**
         * @inheritdoc
         */
        public function setCode(string $code): Shop
        {
            return $this->setData(ResourceModel::FIELD_CODE, $code);
        }

        /**
         * @inheritdoc
         */
        public function getCode2(): string
        {
            return $this->getData(ResourceModel::FIELD_CODE2);
        }

        /**
         * @inheritdoc
         */
        public function setCode2(string $code2): Shop
        {
            return $this->setData(ResourceModel::FIELD_CODE2, $code2);
        }

        /**
         * @inheritdoc
         */
        public function getName(): string
        {
            return $this->getData(ResourceModel::FIELD_NAME);
        }

        /**
         * @inheritdoc
         */
        public function setName(string $name): Shop
        {
            return $this->setData(ResourceModel::FIELD_NAME, $name);
        }

        /**
         * @inheritdoc
         */
        public function getState(): string
        {
            return $this->getData(ResourceModel::FIELD_STATE);
        }

        /**
         * @inheritdoc
         */
        public function setState(string $state): Shop
        {
            return $this->setData(ResourceModel::FIELD_STATE, $state);
        }

        /**
         * @inheritdoc
         */
        public function getCity(): string
        {
            return $this->getData(ResourceModel::FIELD_CITY);
        }

        /**
         * @inheritdoc
         */
        public function setCity(string $city): Shop
        {
            return $this->setData(ResourceModel::FIELD_CITY, $city);
        }

        /**
         * @inheritdoc
         */
        public function getAddress(): string
        {
            return $this->getData(ResourceModel::FIELD_ADDRESS);
        }

        /**
         * @inheritdoc
         */
        public function setAddress(string $address): Shop
        {
            return $this->setData(ResourceModel::FIELD_ADDRESS, $address);
        }

        /**
         * @inheritdoc
         */
        public function getTelephone(): string
        {
            return $this->getData(ResourceModel::FIELD_TELEPHONE);
        }

        /**
         * @inheritdoc
         */
        public function setTelephone(string $telephone): Shop
        {
            return $this->setData(ResourceModel::FIELD_TELEPHONE, $telephone);
        }

        /**
         * @inheritdoc
         */
        public function getCountry(): string
        {
            return $this->getData(ResourceModel::FIELD_COUNTRY);
        }

        /**
         * @inheritdoc
         */
        public function setCountry(string $country): ShopInterface
        {
            return $this->setData(ResourceModel::FIELD_COUNTRY, $country);
        }

        /**
         * @inheritdoc
         */
        public function getZip(): string
        {
            return $this->getData(ResourceModel::FIELD_ZIP);
        }

        /**
         * @inheritdoc
         */
        public function setZip(string $zip): Shop
        {
            return $this->setData(ResourceModel::FIELD_ZIP, $zip);
        }

        /**
         * @inheritdoc
         */
        public function getEmail(): string
        {
            return $this->getData(ResourceModel::FIELD_EMAIL);
        }

        /**
         * @inheritdoc
         */
        public function setEmail(string $email): Shop
        {
            return $this->setData(ResourceModel::FIELD_EMAIL, $email);
        }

        /**
         * @inheritdoc
         */
        public function getLatitude(): float
        {
            return (float) $this->getData(ResourceModel::FIELD_LATITUDE);
        }

        /**
         * @inheritdoc
         */
        public function setLatitude(float $latitude): Shop
        {
            return $this->setData(ResourceModel::FIELD_LATITUDE, (string) $latitude);
        }

        /**
         * @inheritdoc
         */
        public function getLongitude(): float
        {
            return (float) $this->getData(ResourceModel::FIELD_LONGITUDE);
        }

        /**
         * @inheritdoc
         */
        public function setLongitude(float $longitude): Shop
        {
            return $this->setData(ResourceModel::FIELD_LONGITUDE, (string) $longitude);
        }


        /**
         * @inheritdoc
         */
        public function getSubshop(): bool
        {
            return (bool) $this->getData(ResourceModel::FIELD_SUBSHOP);
        }

        /**
         * @inheritdoc
         */
        public function setSubshop(bool $subshop): Shop
        {
            return $this->setData(ResourceModel::FIELD_SUBSHOP, (string) $subshop);
        }


        /**
         * @inheritdoc
         */
        public function getActive(): bool
        {
            return (bool) $this->getData(ResourceModel::FIELD_ACTIVE);
        }

        /**
         * @inheritdoc
         */
        public function setActive(bool $active): Shop
        {
            return $this->setData(ResourceModel::FIELD_ACTIVE, (string) $active);
        }

    }
?>