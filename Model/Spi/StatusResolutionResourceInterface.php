<?php
    /**
     * @Thomas-Athanasiou
     *
     * @author Thomas Athanasiou {thomas@hippiemonkeys.com}
     * @link https://hippiemonkeys.com
     * @link https://github.com/Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys Web Intelligence EE All Rights Reserved.
     * @license http://www.gnu.org/licenses/ GNU General Public License, version 3
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Model\Spi;

    use Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterface,
        Hippiemonkeys\Core\Model\Spi\ModelResourceInterface;

    /**
     * Status Resolution Resource interface
     */
    interface StatusResolutionResourceInterface
    extends ModelResourceInterface
    {
        const
            FIELD_CODE = 'code',
            FIELD_STATUS_ID = 'status_id';

        /**
         * Save Status Resolution data
         *
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterface $statusResolution
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Model\Spi\StatusResolutionResourceInterface
         */
        function saveStatusResolution(StatusResolutionInterface $statusResolution): StatusResolutionResourceInterface;

        /**
         * Load a Status Resolution by Id
         *
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterface $statusResolution
         * @param mixed $id
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Model\Spi\StatusResolutionResourceInterface
         */
        function loadStatusResolutionById(StatusResolutionInterface $statusResolution, $id): StatusResolutionResourceInterface;

        /**
         * Load a Status Resolution by Code
         *
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterface $statusResolution
         * @param string $code
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Model\Spi\StatusResolutionResourceInterface
         */
        function loadStatusResolutionByCode(StatusResolutionInterface $statusResolution, string $code): StatusResolutionResourceInterface;

        /**
         * Delete the Status Resolution
         *
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterface $statusResolution
         *
         * @return bool
         */
        function deleteStatusResolution(StatusResolutionInterface $statusResolution): bool;
    }
?>