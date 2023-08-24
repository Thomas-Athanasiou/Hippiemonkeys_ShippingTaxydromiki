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

    namespace Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel\Resolution;

    use Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionSearchResultInterface as SearchResultInterface,
        Hippiemonkeys\ShippingTaxydromiki\Model\StatusResolution as Model,
        Hippiemonkeys\ShippingTaxydromiki\Model\Spi\StatusResolutionResourceInterface as ResourceInterface,
        Hippiemonkeys\Core\Model\ResourceModel\Collection\AbstractCollection;

    class Collection
    extends AbstractCollection
    implements SearchResultInterface
    {
        /**
         * {@inheritdoc}
         */
        protected function _construct()
        {
            $this->_init(Model::class, ResourceInterface::class);
        }
    }
?>