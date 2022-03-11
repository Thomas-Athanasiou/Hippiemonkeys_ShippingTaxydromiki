<?php
    /**
     * @author Thomas Athanasiou at Hippiemonkeys
     * @copyright Copyright (c) 2022 Hippiemonkeys (https://hippiemonkeys.com)
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Api\Data;

    use Magento\Framework\Api\SearchResultsInterface;

    interface JobSearchResultInterface
    extends SearchResultsInterface
    {
        /**
         * Gets collection of Job items.
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface[] Array of collection line items.
         */
        public function getItems();

        /**
         * Sets collection of Job items.
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface[] $jobs
         * @return $this
         */
        public function setItems(array $jobs);
    }
?>