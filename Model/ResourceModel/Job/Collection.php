<?php
    /**
     * @Thomas-Athanasiou
     *
     * @author Thomas Athanasiou at Hippiemonkeys
     * @link https://github.com/Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys (https://hippiemonkeys.com)
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel\Job;

    use Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel\Collection\AbstractCollection,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobSearchResultInterface as SearchResultInterface,

        Hippiemonkeys\ShippingTaxydromiki\Model\Job as Model,
        Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel\Job as ResourceModel;

    class Collection
    extends AbstractCollection
    implements SearchResultInterface
    {
        /**
         * @inheritdoc
         */
        protected function _construct()
        {
            $this->_init(Model::class, ResourceModel::class);
        }
    }
?>