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

    interface StatusResolutionSearchResultInterface
    extends SearchResultsInterface
    {
        /**
         * Gets collection of Status Resolution items.
         *
         * @api
         * @access public
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterface[]
         */
        function getItems();

        /**
         * Sets collection of Status Resolution items.
         *
         * @api
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterface[] $statusResolutions
         *
         * @return $this
         */
        function setItems(array $statusResolutions);
    }
?>