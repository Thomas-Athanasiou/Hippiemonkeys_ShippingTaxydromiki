<?php
    /**
     * @Thomas-Athanasiou
     *
     * @author Thomas Athanasiou {thomas@hippiemonkeys.com}
     * @link https://hippiemonkeys.com
     * @link https://github.com/Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys Web Inteligence EE All Rights Reserved.
     * @license http://www.gnu.org/licenses/ GNU General Public License, version 3
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Model;

    use Magento\Framework\DataObject,
        Magento\Quote\Model\Quote\Address\RateRequest;

    class Carrier
    extends AbstractCarrier
    {
        /**
         * {@inheritdoc}
         */
        public function collectRates(RateRequest $request)
        {
            return false;
        }

        /**
         * {@inheritdoc}
         */
        public function getAllowedMethods(): array
        {
            return [];
        }

        /**
         * {@inheritdoc}
         */
        protected function doCreateJobRequest(DataObject $request): object
        {
           return new \stdClass;
        }
    }
?>