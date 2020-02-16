<?php

defined('TYPO3_MODE') or die();

if (TYPO3_MODE === 'BE') {
    $icons = [
        'ext-news-type-product' => 'news_domain_model_news_as_product.svg',
    ];
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    foreach ($icons as $identifier => $path) {
        if (!$iconRegistry->isRegistered($identifier)) {
            $iconRegistry->registerIcon(
                $identifier,
                \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                ['source' => 'EXT:cart_news/Resources/Public/Icons/' . $path]
            );
        }
    }
}

// Cart AddToCartFinisher

if (TYPO3_MODE === 'FE') {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['cart']['CartNews']['Cart']['AddToCartFinisher'] =
        \Extcode\CartNews\Domain\Finisher\Cart\AddToCartFinisher::class;
}
