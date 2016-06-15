<?php

class Space48_CertifiedShops_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_CERTIFIED_SHOPS = 'google/space48_certifiedshops/';

    /**
     * Returns config data from specified field within
     * the module X-path
     *
     * @param string
     * @return string
     */
    public function getConfig($field)
    {
        return Mage::getStoreConfig(self::XML_PATH_CERTIFIED_SHOPS . $field);
    }

    /**
     * Checks the items for any backorders and returns
     * true if any are found
     *
     * @param object
     * @return bool
     */
    public function getOrderHasBackorders($items)
    {
        foreach ($items as $item) {
            if ($item->getQtyBackordered() !== null) {
                return true;
            }
        }
        return false;
    }

    /**
     * Returns two-letter country ID from shipping address
     * if found, otherwise billing address
     *
     * @param Mage_Sales_Model_Order
     * @return mixed
     */
    public function getOrderCountryId($order)
    {
        if (!$order->getid()) {
            return false;
        }

        if ($id = $order->getShippingAddress()->getCountryId()) {
            return $id;
        }

        if ($id = $order->getBillingAddress()->getCountryId()) {
            return $id;
        }

        return false;
    }
}