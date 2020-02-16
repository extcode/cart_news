<?php
namespace Extcode\CartNews\Domain\Model;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class NewsProduct extends \GeorgRinger\News\Domain\Model\News
{
    /**
     * @var string
     */
    protected $sku = '';

    /**
     * @var float
     */
    protected $price = 0.0;

    /**
     * @var int
     */
    protected $taxClassId = 1;

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return bool
     */
    public function isNetPrice(): bool
    {
        return GeneralUtility::makeInstance(ExtensionConfiguration::class)
            ->get('cart_news', 'inputIsNetPrice');
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getTaxClassId(): int
    {
        return $this->taxClassId;
    }
}
