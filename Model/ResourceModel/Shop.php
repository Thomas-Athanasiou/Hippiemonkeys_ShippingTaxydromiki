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

    namespace Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel;

    use Hippiemonkeys\Core\Model\ResourceModel\AbstractResource,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterface,
        Hippiemonkeys\ShippingTaxydromiki\Model\Spi\ShopResourceInterface;

    class Shop
    extends AbstractResource
    implements ShopResourceInterface
    {
        protected const
            TABLE_MAIN = 'hippiemonkeys_shippingtaxydromiki_shop';

        /**
         * {{@inheritdoc}}
         */
        protected function _construct()
        {
            $this->_init(static::TABLE_MAIN, static::FIELD_ID);
        }

        /**
         * {@inheritdoc}
         */
        public function saveShop(ShopInterface $shop): ShopResourceInterface
        {
            return $this->saveModel($shop);
        }

        /**
         * {@inheritdoc}
         */
        public function loadShopById(ShopInterface $shop, $id): ShopResourceInterface
        {
            return $this->loadModel($shop, $id, static::FIELD_ID);
        }

        /**
         * {@inheritdoc}
         */
        public function deleteShop(ShopInterface $shop): bool
        {
            return $this->deleteModel($shop);
        }
    }
?>