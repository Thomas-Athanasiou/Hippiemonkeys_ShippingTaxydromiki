<?php
    /**
     * @Thomas-Athanasiou
     *
     * @author Thomas Athanasiou at Hippiemonkeys
     * @link https://github.com/Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys Web Inteligence EE (https://hippiemonkeys.com)
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
         * @api
         * @access public
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface[] Array of collection line items.
         */
        function getItems();

        /**
         * Sets collection of Job items.
         *
         * @api
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface[] $jobs
         *
         * @return $this
         */
        function setItems(array $jobs);
    }
?>