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

    namespace Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel\Shop;

    use Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopSearchResultInterface as SearchResultInterface,
        Hippiemonkeys\ShippingTaxydromiki\Model\Shop as Model,
        Hippiemonkeys\ShippingTaxydromiki\Model\Spi\ShopResourceInterface as ResourceInterface,
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