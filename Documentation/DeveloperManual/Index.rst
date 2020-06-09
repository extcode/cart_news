.. include:: ../Includes.txt

..  _developer_manual:

================
Developer Manual
================

In addition to the possible use in a TYPO3, the extension serves in particular
to show how an own product table can be linked to EXT:cart.

You need a form and an add to cart finisher for the conversion. The form is
sent to a controller of EXT:cart. In order to decide which finisher to use, a
unique product type must be passed. Furthermore the form has to transmit the
information that the AddToCartFinisher needs to load the correct product and
prepare it for the shopping cart.

.. NOTE::
   Thereby one is not directed to a TYPO3 database. The product can be created
   from the transferred information or loaded via an API.

The Form
========

The form itself needs two pieces of information. First, the page ID of the cart
page and the PageType, if the products are to be added to the shopping cart via
AJAX request. Both information have to be configured for EXT:cart anyway and
can be loaded in the controller via the ConfigurationManager, or as in this
example copied into the TypoScript configuration of EXT:news.

::

   <f:form id="news-{newsItem.uid}"
           class="add-to-cart-form"
           pageUid="{settings.cart.pid}"
           extensionName="Cart"
           pluginName="Cart"
           controller="Cart\Product"
           action="add"
           method="post"
           pageType="{f:if(condition:'{settings.addToCartByAjax}', then:'{settings.addToCartByAjax}', else:'')}"
           additionalAttributes="{data-ajax: '{f:if(condition: \'{settings.addToCartByAjax}\', then: \'1\', else: \'0\')}', data-type: 'news', data-id: '{newsItem.uid}'}">

      ...

   </f:form>

The form then contains a field for the number. In theory, this could also be
a non-visible field with a fixed number. Two other non-visible form fields
transmit the product type "CartNews" and the ID of the news item.

::

   <input type="hidden" name="tx_cart_cart[productType]" value="CartNews">
   <input type="hidden" name="tx_cart_cart[newsItem]" value="{newsItem.uid}">

   <input class="form-control" type="text"name="tx_cart_cart[quantity]" value="1">
   <input type="submit" class="btn btn-secondary" value="{f:translate(key:'tx_cartnews.add_to_cart', extensionName: 'CartNews')}">

The Finisher
============

So that the controller of EXT:cart can decide which finisher is responsible for
this product type, it must be registered in the `ext_localconf.php` of the own
product extension or in the SitePackage.

::

   // Cart AddToCartFinisher

   if (TYPO3_MODE === 'FE') {
       $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['cart']['CartNews']['Cart']['AddToCartFinisher'] =
           \Extcode\CartNews\Domain\Finisher\Cart\AddToCartFinisher::class;
   }

The class registered here must implement the interface
`\Extcode\Cart\Domain\Finisher\Cart\AddToCartFinisherInterface`.

This interface has two methods. One `checkAvailability` is called to check in
different places if there are enough products in the stock. Since this
extension sells news articles and these are traded as virtual products by the
implementation, the implementation is relatively simple.

::

   public function checkAvailability(
       Request $request,
       Product $cartProduct,
       Cart $cart,
       $mode = 'update'
   ): AvailabilityResponse {
       return GeneralUtility::makeInstance(
           AvailabilityResponse::class
       );
   }

The `\Extcode\Cart\Domain\Model\Dto\AvailabilityResponse` class says by default
that a product is available. It could also be used to check the availability
of a product and return a message in addition to the status. A corresponding
example can be found in EXT:cart_products.

The second method `getProductFromRequest` gets the request and based on the
form arguments the product for the shopping cart must be created.

In the implementation in EXT:cart_news, the data record is first loaded from
the database using the transferred message ID.
With this record and the other information from the request, the method
`getCartProductFromNews` is then called.
This method returns a virtual product of type `\Extcode\Cart\Domain\Model\Cart\Product`.

Since EXT:cart_news does not need any stock management, nothing needs to be
considered at this point when customers place an order.
