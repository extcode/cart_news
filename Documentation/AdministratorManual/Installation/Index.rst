.. include:: ../../Includes.txt

============
Installation
============

Installation
============

The extension can be installed in 3 different ways. However, installation via composer is recommended.

Installation using composer
---------------------------

The recommended way to install the extension is by using `Composer <https://getcomposer.org/>`_.
In your Composer based TYPO3 project root, just do

`composer require extcode/cart-news`.

Installation using git
-----------------------
You can get the latest version from git by using the git command:

::

   git clone git@github.com:extcode/cart_news.git

Installation from TYPO3 Extension Repository (TER)
--------------------------------------------------

Download and install the extension with the extension manager module.

Include static TypoScript
=========================

The extension ships some TypoScript code which needs to be included.

#. Switch to the root page of your site.

#. Switch to the **Template module** and select *Info/Modify*.

#. Press the link **Edit the whole template record** and switch to the tab *Includes*.

#. Select **Shopping Cart - Cart News** at the field *Include static (from extensions):*
