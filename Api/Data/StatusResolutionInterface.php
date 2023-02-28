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

    use Hippiemonkeys\Core\Api\Data\ModelInterface,
        Hippiemonkeys\ShippingTrack\Api\Data\StatusInterface;

    interface StatusResolutionInterface
    extends ModelInterface
    {
        /**
         * Gets Code
         *
         * @api
         * @access public
         *
         * @return string
         */
        function getCode(): string;

        /**
         * Sets Code
         *
         * @api
         * @access public
         *
         * @param string $code
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterface
         */
        function setCode(string $code): StatusResolutionInterface;

        /**
         * Gets Status
         *
         * @api
         * @access public
         *
         * @return \Hippiemonkeys\ShippingTrack\Api\Data\StatusInterface
         */
        function getStatus(): StatusInterface;

        /**
         * Sets Status
         *
         * @api
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTrack\Api\Data\StatusInterface $status
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterface
         */
        function setStatus(StatusInterface $status): StatusResolutionInterface;
    }
?>