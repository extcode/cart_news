<?php

namespace Extcode\CartEvents\Tests\Domain\Model;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class NewsProductTest extends FunctionalTestCase
{
    protected $configurationToUseInTestInstance = [
        'EXTENSIONS' => [
            'cart_news' => [
                'inputIsNetPrice' => '0',
            ],
        ],
    ];

    protected $testExtensionsToLoad = [
        'typo3conf/ext/cart',
        'typo3conf/ext/news',
        'typo3conf/ext/cart_news',
    ];

    /**
     * @var \Extcode\CartNews\Domain\Model\NewsProduct
     */
    protected $newsProduct = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->newsProduct = new \Extcode\CartNews\Domain\Model\NewsProduct();
    }

    protected function tearDown(): void
    {
        unset($this->newsProduct);
        parent::tearDown();
    }

    /**
     * @test
     */
    public function testIsNetPriceReturnsTrueForConfiguration(): void
    {
        $this->assertSame(
            false,
            $this->newsProduct->isNetPrice()
        );
    }
}
