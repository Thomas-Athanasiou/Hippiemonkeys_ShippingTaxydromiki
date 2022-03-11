<?php
    /**
     * @author Thomas Athanasiou at Hippiemonkeys
     * @copyright Copyright (c) 2022 Hippiemonkeys (https://hippiemonkeys.com)
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Model;

    use Magento\Framework\DataObject;

    class Carrier
    extends AbstractCarrier
    {
        /**
         * @inheritdoc
         */
        public function collectRates($request)
        {
            return false;
        }

        /**
         * @inheritdoc
         */
        public function getAllowedMethods(): array
        {
            return [];
        }

        /**
         * @inheritdoc
         */
        protected function doCreateJobRequest(DataObject $request): object
        {
           new \stdClass;
        }
    }
?>