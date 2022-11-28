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

    namespace Hippiemonkeys\ShippingTaxydromiki\Api\Helper\Taxydromiki;

    use Hippiemonkeys\ShippingTaxydromiki\Api\Helper\TaxydromikiInterface;

    interface UpdateShopsInterface
    extends TaxydromikiInterface
    {
        /**
         * Updates persistent shops from the external carrier service
         *
         * @api
         * @access public
         */
        public function updateShops(): void;
    }
?>