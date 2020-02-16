<?php
declare(strict_types=1);

defined('TYPO3_MODE') or die();

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

$_LLL_cart = 'LLL:EXT:cart/Resources/Private/Language/locallang_db.xlf';
$_LLL_db = 'LLL:EXT:cart_news/Resources/Private/Language/locallang_db.xlf';
$_LLL_tca = 'LLL:EXT:cart_news/Resources/Private/Language/locallang_tca.xlf';

$fields = [
    'sku' => [
        'exclude' => 1,
        'label' => $_LLL_db . ':tx_news_domain_model_news.sku',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'required,trim'
        ],
    ],

    'price' => [
        'displayCond' => 'FIELD:type:=:news_product',
        'label' => $_LLL_db . ':tx_news_domain_model_news.price.gross',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'required,double2',
            'default' => '0.00',
        ]
    ],

    'tax_class_id' => [
        'displayCond' => 'FIELD:type:=:news_product',
        'label' => $_LLL_cart . ':tx_cart.tax_class_id',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [$_LLL_cart . ':tx_cart.tax_class_id.1', 1],
                [$_LLL_cart . ':tx_cart.tax_class_id.2', 2],
                [$_LLL_cart . ':tx_cart.tax_class_id.3', 3],
            ],
            'size' => 1,
            'minitems' => 1,
            'maxitems' => 1,
        ],
    ],
];

$GLOBALS['TCA']['tx_news_domain_model_news']['palettes']['palette_pricefields'] = [
    'canNotCollapse' => true,
    'showitem' => 'price,tax_class_id'
];

// add fields to TCA
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'tx_news_domain_model_news',
    $fields
);
$GLOBALS['TCA']['tx_news_domain_model_news']['types']['news_product'] = $GLOBALS['TCA']['tx_news_domain_model_news']['types'][0];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_news_domain_model_news',
    ',--div--;' . $_LLL_tca . ':tab.news_as_product,sku,--palette--;;palette_pricefields',
    'news_product',
    'after:bodytext'
);

// replace price label for net price configuration
$inputIsNetPrice = GeneralUtility::makeInstance(ExtensionConfiguration::class)
    ->get('cart_news', 'inputIsNetPrice');
if ((bool)$inputIsNetPrice) {
    $GLOBALS['TCA']['tx_news_domain_model_news']['columns']['price']['label'] = $_LLL_db . ':tx_news_domain_model_news.price.net';
}

// add typeicons
$GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['typeicon_classes']['news_product'] = 'ext-news-type-product';
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['type']['config']['items'][] = [$_LLL_db . ':tx_news_domain_model_news.type.I.news_as_product', 'news_product', 'ext-news-type-product'];
