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

    namespace Hippiemonkeys\ShippingTaxydromiki\Api;

    use Magento\Framework\Api\SearchCriteriaInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionSearchResultInterface as SearchResultInterface;

    interface StatusResolutionRepositoryInterface
    {
        /**
         * Gets Status Resolution by Id
         *
         * @api
         * @access public
         *
         * @param mixed $id
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterface
         */
        function getById($id): StatusResolutionInterface;

        /**
         * Gets Status Resolution by Code
         *
         * @api
         * @access public
         *
         * @param string $code
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterface
         */
        function getByCode(string $code): StatusResolutionInterface;

        /**
         * Gets list by Search Criteria
         *
         * @api
         * @access public
         *
         * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionSearchResultInterface
         */
        function getList(SearchCriteriaInterface $searchCriteria): SearchResultInterface;

        /**
         * Deletes Status Resolution
         *
         * @api
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterface $statusResolution
         *
         * @return bool
         */
        function delete(StatusResolutionInterface $statusResolution): bool;

        /**
         * Saves Status Resolution
         *
         * @api
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterface $statusResolution
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterface
         */
        function save(StatusResolutionInterface $statusResolution): StatusResolutionInterface;
    }
?>