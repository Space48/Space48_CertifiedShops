<?php class Space48_CertifiedShops_Block_Success extends Mage_Core_Block_Template
{
    protected $hasLastOrder = false;
    protected $lastOrder;
    protected $visibleItems;
    protected $allItems;
    protected $testOrder = false;
    protected $estimate;

    protected function _construct()
    {
        $this->setLastOrder();
        $this->estimate = Mage::getModel('space48_certifiedshops/estimate');
        $this->estimate->setOrder($this->lastOrder);
        $this->estimate->setDates();
        parent::_construct();
    }

    /**
     * @return bool
     */
    public function hasLastOrder()
    {
        return $this->hasLastOrder;
    }

    /**
     * @return object
     */
    public function getLastOrder()
    {
        return $this->lastOrder;
    }

    /**
     * @return mixed
     */
    public function getEstimatedShippingDate()
    {
        return $this->estimate->getEstimatedShippingDate();
    }

    /**
     * @return mixed
     */
    public function getEstimatedDeliveryDate()
    {
        return $this->estimate->getEstimatedDeliveryDate();
    }

    /**
     * Checks registry for a test order
     */
    protected function setIsTestOrderPage()
    {
        $order = Mage::registry('certifiedshops_order');

        if ($order) {
            $this->testOrder = $order;
        }
    }

    /**
     * Sets the last order, whether test or real
     */
    protected function setLastOrder()
    {
        $this->setIsTestOrderPage();

        if ($this->testOrder !== false)
        {
            $order = $this->testOrder;
        } else {
            $order = Mage::getModel('sales/order')
                ->loadByIncrementId(Mage::getSingleton('checkout/session')->getLastRealOrderId());
        }

        if ($order) {
            $this->hasLastOrder = true;
            $this->lastOrder = $order;
            $this->visibleItems = $order->getAllVisibleItems();
            $this->allItems = $order->getAllItems();
            $this->setBillingAddress();
            $this->setShippingAddress();
        }
    }

    /**
     * @return object
     */
    public function getAllVisibleItems() {
        return $this->visibleItems;
    }

    /**
     * @return object|Mage_Customer_Model_Customer
     */
    public function getCustomer() {
        return Mage::getModel('customer/customer')
            ->load($this->lastOrder->getCustomerId());
    }

    /**
     * @return string
     */
    public function getFormattedBaseUrl() {
        return str_replace('/', '', str_replace(array('http://','https://'), '', Mage::getBaseUrl()));
    }

    /**
     * @return object
     */
    public function getOrderCountry() {
        if($this->lastOrder->getShippingAddressId() != '') {

            $shipping_address = Mage::getModel('sales/order_address')
                ->load($this->lastOrder->getShippingAddressId());

            return $shipping_address->getCountry();
        } else {
            $billing_address = Mage::getModel('sales/order_address')
                ->load($this->lastOrder->getBillingAddressId());

            return $billing_address->getCountry();
        }
    }

    /**
     * @return string
     */
    public function isVirtual() {
        return ($this->lastOrder->getIsVirtual() === '0') ? "N" : "Y";
    }

    /**
     * @return string
     */
    public function getOrderHasPreOrders() {
        $hasPreOrders = $this->helper('space48_certifiedshops')
            ->getOrderHasBackorders($this->allItems);

        return ($hasPreOrders !== false) ? 'Y' : 'N';
    }

    /**
     * @return decimal
     */
    public function formatPrice($price)
    {
        return number_format($price, 2, '.', '');
    }
}