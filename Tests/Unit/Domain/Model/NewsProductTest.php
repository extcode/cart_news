<?php

namespace Extcode\CartEvents\Tests\Domain\Model;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class NewsProductTest extends UnitTestCase
{
    /**
     * @var \Extcode\CartNews\Domain\Model\NewsProduct
     */
    protected $newsProduct = null;

    protected function setUp()
    {
        $this->newsProduct = new \Extcode\CartNews\Domain\Model\NewsProduct();
    }

    protected function tearDown()
    {
        unset($this->newsProduct);
    }

    /**
     * @test
     */
    public function getSkuReturnsInitialValueForSku()
    {
        $this->assertSame(
            '',
            $this->newsProduct->getSku()
        );
    }

    /**
     * @test
     */
    public function getPriceReturnsInitialValueForPrice()
    {
        $this->assertSame(
            0.00,
            $this->newsProduct->getPrice()
        );
    }

    /**
     * @test
     */
    public function getTaxClassIdReturnsInitialValueForTaxClassId()
    {
        $this->assertSame(
            1,
            $this->newsProduct->getTaxClassId()
        );
    }
}
