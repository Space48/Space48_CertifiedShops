<?php class Space48_CertifiedShops_TestController extends Mage_Core_Controller_Front_Action
{
    public function successAction()
    {
        if (!$this->helper()->getConfig('active') ||
            !$this->helper()->getConfig('enable_test')
        ) {
            Mage::getSingleton('core/session')
                ->addError("Test mode not enabled");
            $this->norouteAction();
            return;
        }

        $orderIncrementId = $this->getRequest()->getParam('order');

        if (empty($orderIncrementId)) {
            Mage::getSingleton('core/session')
                ->addError("No order ID");
        } else {
            $order = Mage::getModel('sales/order')
                ->loadByIncrementId($orderIncrementId);

            if (!$order->getId()) {
                Mage::getSingleton('core/session')
                    ->addError("No order exists with ID #" . $orderIncrementId);
            } else {
                Mage::register("certifiedshops_order", $order);
            }
        }

        $this->loadLayout();
        $this->renderLayout();
    }

    public function helper()
    {
        return Mage::helper('space48_certifiedshops');
    }
}