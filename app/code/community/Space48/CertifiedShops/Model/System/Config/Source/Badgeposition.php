<?php class Space48_CertifiedShops_Model_System_Config_Source_Badgeposition
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'BOTTOM_RIGHT', 'label' =>
                Mage::helper('space48_certifiedshops')->__('Bottom Right')),
            array('value' => 'BOTTOM_LEFT', 'label' =>
                Mage::helper('space48_certifiedshops')->__('Bottom Left')),
            array('value' => 'USER_DEFINED', 'label' =>
                Mage::helper('space48_certifiedshops')->__('User Defined'))
        );
    }
}