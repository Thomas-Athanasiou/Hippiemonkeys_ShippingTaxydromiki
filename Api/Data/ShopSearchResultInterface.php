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

    namespace Hippiemonkeys\ShippingTaxydromiki\Api\Data;

    use Magento\Framework\Api\SearchResultsInterface;

    interface ShopSearchResultInterface
    extends SearchResultsInterface
    {
        /**
         * Gets collection items
         *
         * @api
         * @access public
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterface[] Array of collection items
         */
        function getItems();

        /**
         * Sets collection line items
         *
         * @api
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterface[] $shops
         *
         * @return $this
         */
        function setItems(array $shops);
    }
?>