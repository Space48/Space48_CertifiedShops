<?php class Space48_CertifiedShops_Block_Badge extends Mage_Core_Block_Template
{
    protected $fullActionName;

    /**
     * Checks if a Google Shopping ID has been set and
     * if we're on a product page
     *
     * @return bool
     */
    public function isGoogleOfferItemPage() {
        if ($this->helper('space48_certifiedshops')
            ->getConfig('google_shopping_account_id')) {
            $this->fullActionName = $this->getAction()->getFullActionName();
            if (($this->fullActionName=='catalog_product_view')) {
                return true;
            }
        }
        return false;
    }

    /**
     * Returns the SKU of the current product in registry
     *
     * @return string
     */
    public function getGoogleBaseOfferId() {

        if ($this->fullActionName=='catalog_product_view') {
            $product  = Mage::registry('current_product');
            return $product->getSku();
        }
        return false;
    }
}