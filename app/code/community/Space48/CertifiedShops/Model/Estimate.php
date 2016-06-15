<?php class Space48_CertifiedShops_Model_Estimate extends Mage_Core_Model_Abstract
{
    protected $order;
    protected $estimatedShippingDays = "";
    protected $estimatedDeliveryDays = "";

    /**
     * @param Mage_Sales_Model_Order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return object
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return object
     */
    public function helper()
    {
        return Mage::helper('space48_certifiedshops');
    }

    /**
     * @param integer
     */
    public function setEstimatedShippingDays($days)
    {
        $this->estimatedShippingDays = $days;
    }

    /**
     * @param integer
     */
    public function setEstimatedDeliveryDays($days)
    {
        $this->estimatedDeliveryDays = $days;
    }

    /**
     * @return integer
     */
    public function getEstimatedShippingDays()
    {
        return $this->estimatedShippingDays;
    }

    /**
     * @return integer
     */
    public function getEstimatedDeliveryDays()
    {
        return $this->estimatedDeliveryDays;
    }

    /**
     * Returns the estimated shipping date
     *
     * @return string
     */
    public function getEstimatedShippingDate()
    {
        return $this->formatDate($this->estimatedShippingDays);
    }

    /**
     * Returns the estimated delivery date
     *
     * @return string
     */
    public function getEstimatedDeliveryDate()
    {
        return $this->formatDate($this->estimatedDeliveryDays);
    }

    /**
     * Returns a date based on the number passed
     *
     * @param int
     * @return string
     */
    protected function formatDate($days)
    {
        if (is_numeric($days)) {
            return date('Y-m-d', strtotime($days . ' weekdays'));
        }

        return false;
    }

    /**
     * Main function for looping through items to discover greatest delivery date
     * 
     * @return bool
     */
    public function setDates()
    {
        $this->estimatedShippingDays = $this->helper()->getConfig('default_estimated_shipping');
        $this->estimatedDeliveryDays = $this->helper()->getConfig('default_estimated_delivery');

        Mage::dispatchEvent('certified_shops_estimates_after',
            array('estimate' => $this));

        return false;
    }
}