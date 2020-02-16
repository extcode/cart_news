.. include:: ../../Includes.txt

=============
Configuration
=============

The extension does not bring its own templates, but only extends the views
of EXT:news by a partial.
This partial must be copied into the own SitePackage and adapted there,
or it must be used by EXT:cart_news:

::

   plugin.tx_news {
       view {
           partialRootPaths {
               100 = EXT:cart_news/Resources/Private/Partials
           }
       }
   }

The partial still needs the information on which page the shopping cart is
located and whether products should be added via AJAX request. These can be
taken from the respective configurations.

::

   plugin.tx_news {
       settings {
           addToCartByAjax = plugin.tx_cart.settings.addToCartByAjax

           cart.pid < plugin.tx_cart.settings.cart.pid
       }
   }


If you want to display the price as well, the configuration for the price
display should be taken over into the settings of EXT:news. This way they
are also available in ViewHelper.

::

   plugin.tx_news {
       settings {
           format.currency < plugin.tx_cart.settings.format.currency
       }
   }

.. NOTE::
   It is important that this TypoScript is included only after the TypoScript
   of EXT:cart, so that copying the configuration can work.