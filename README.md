## Google Certified Shops for Magento

### About this Extension

This extension implements the GCS [badge code](https://support.google.com/trustedstoresmerchant/answer/6063080?hl=en-GB&ref_topic=6063044#variables) on every page of the website frontend. It will also display the [order success](https://support.google.com/trustedstoresmerchant/answer/6063087?hl=en-GB&ref_topic=6063044) page purchase protection popup when a customer completes an order.

[More Information about Google Certified Shops](https://support.google.com/trustedstoresmerchant/answer/6063065?hl=en-GB&ref_topic=6063044)

### Compatibility

- Magento Community Edition 1.4 to 1.9
- Magento Enterprise Edition 1.12 to 1.14

### Manual Installation

1. Unpack the extension ZIP file in your Magento root directory
2. Clear the Magento cache: **System > Cache Management**
3. Log out the Magento admin and log back in to clear the ACL list
4. Recompile if you are using the Magento Compiler

### Usage

To enable and configure this module you need to login to the Magento admin and go to **System > Configuration > Google API > Google Certified Shops** and set 'Enable' to 'Yes'.

![Configuration](https://github.com/Space48/Space48_CertifiedShops/blob/master/assets/config.png)

#### Link with Google Shopping

Optionally you can enter your Google Shopping ID to link products with those submitted in Merchant Centre feeds.

|Field|Value|
|---|---|
|Google Shopping Account ID|Your Google Shopping ID obtained from your account|
|Google Shopping Language|The language used by your Google Shopping account|
|Google Shopping Country|The default country used by your Google Shopping account|

#### Default Estimated Delivery/Shipping Days

You must provide an estimate on how many days it takes to dispatch an order (shipping) and how many days it takes for that item to be delivered (delivery).

These are the figures that will be used by the order confirmation code if these estimates aren't modified by an [observer as described below](#custom-shipping-estimates-with-observer).

#### Badge Position

You can also change the position of the badge which is set to 'Bottom Right' by default. By setting to 'User Defined' the badge will appear in the element with ID `GTS_CONTAINER` which is added to **app/design/frontend/base/default/template/space48/certifiedshops/badge.phtml** by default.

#### Testing URL

A cool feature of this extension is the ability to test the order success code without having to keep creating orders. Within the module configuration change 'Enable Testing URL' to 'Yes'.

Navigate to your site's frontend and go to **/certifiedshops/success/order/** and enter any order existing order ID after the trailing forward slash in the URL. For example:

https://local.space48.com/certifiedshops/test/success/order/100190348

The page will display a preview of the order success code for that order, something like this:

![Configuration](https://github.com/Space48/Space48_CertifiedShops/blob/master/assets/test.png)

### Custom Shipping Estimates with Observer

By creating a very basic local module it's possible to hook into this extension to set custom shipping and delivery estimates. The event you want to listen for is called `certified_shops_estimates_after`. This allows all the custom business logic to be kept separate from the main module.

Below is an example of how data can be retrieved and set using an observer:

````
public function setCustomEstimates(Varien_Event_Observer $observer)
{
    $estimate = $observer->getEvent()->getEstimate();
    $order = $estimate->getOrder();

    $estimate->setEstimatedShippingDays(6);
    $estimate->setEstimatedDeliveryDays(8);
}
````

Alternatively, you can set a fixed date for each estimate (this will override any days that have been set):

````
public function setCustomEstimates(Varien_Event_Observer $observer)
{
    $estimate = $observer->getEvent()->getEstimate();
    $order = $estimate->getOrder();

    $estimate->setEstimatedShippingDate("2016-06-27");
    $estimate->setEstimatedDeliveryDate("2016-06-29");
}
````

### Testing the Integration

It is recommended to add an extra testing shop for local testing, this can then be changed to teh staging domain for staging testing. Login to your Certified Shops dashboard and go to **Account Management > Shops**. Simply add an extra shop then follow the testing instructions.

![Testing](https://github.com/Space48/Space48_CertifiedShops/blob/master/assets/testing.png)

[More Information about Testing](https://support.google.com/trustedstoresmerchant/answer/6063088?hl=en-GB&ref_topic=6063044)

### Support

If you have any problems with this extension, please [open an issue](https://github.com/Space48/Space48_CertifiedShops/issues) on GitHub. Feel free to make a Pull Request if you want to contribute.

### Disable the Module

To completely disable the module open **app/etc/modules/Space48_CertifiedShops.xml** and change `<active>true</active>` to `<active>false</active>`

After doing this, clear the cache and reindex your data.
