<?php
declare(strict_types=1);
namespace Extcode\CartNews\Domain\Finisher\Cart;

use Extcode\Cart\Domain\Finisher\Cart\AddToCartFinisherInterface;
use Extcode\Cart\Domain\Model\Cart\Cart;
use Extcode\Cart\Domain\Model\Cart\Product;
use Extcode\Cart\Domain\Model\Dto\AvailabilityResponse;
use Extcode\CartNews\Domain\Model\NewsProduct;
use Extcode\CartNews\Domain\Repository\NewsProductRepository;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Web\Request;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class AddToCartFinisher implements AddToCartFinisherInterface
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var NewsProductRepository
     */
    protected $newsRepository;

    /**
     * @param Request $request
     * @param Product $cartProduct
     * @param Cart $cart
     * @param string $mode
     *
     * @return AvailabilityResponse
     */
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

    /**
     * @param Request $request
     * @param Cart $cart
     *
     * @return array
     */
    public function getProductFromRequest(
        Request $request,
        Cart $cart
    ) {
        $requestArguments = $request->getArguments();
        $taxClasses = $cart->getTaxClasses();

        $errors = [];
        $cartProducts = [];

        if (!(int)$requestArguments['newsItem']) {
            $errors[] = [
                'messageBody' => LocalizationUtility::translate(
                    'tx_cartnews.error.invalid_news',
                    'cart_news'
                ),
                'severity' => AbstractMessage::ERROR,
            ];

            return [$errors, $cartProducts];
        }

        $quantity = 0;

        if ((int)$requestArguments['quantity']) {
            $quantity = (int)$requestArguments['quantity'];
        }

        if ($quantity < 0) {
            $errors[] = [
                'messageBody' => LocalizationUtility::translate(
                    'tx_cart.error.invalid_quantity',
                    'cart_news'
                ),
                'severity' => AbstractMessage::WARNING,
            ];

            return [$errors, $cartProducts];
        }

        $this->objectManager = GeneralUtility::makeInstance(
            ObjectManager::class
        );
        $this->newsRepository = $this->objectManager->get(
            NewsProductRepository::class
        );

        $news = $this->newsRepository->findByUid((int)$requestArguments['newsItem']);

        if (!$news) {
            $errors[] = [
                'messageBody' => LocalizationUtility::translate(
                    'tx_cartnews.error.news_not_found',
                    'cart_news'
                ),
                'severity' => AbstractMessage::WARNING,
            ];

            return [$errors, $cartProducts];
        }

        $newProduct = $this->getCartProductFromNews($news, $quantity, $taxClasses);

        $this->checkAvailability($request, $newProduct, $cart);

        return [$errors, [$newProduct]];
    }

    /**
     * @param NewsProduct $news
     * @param int $quantity
     * @param array $taxClasses
     *
     * @return Product
     */
    protected function getCartProductFromNews(
        NewsProduct $news,
        int $quantity,
        array $taxClasses
    ) {
        $product = new Product(
            'CartNews',
            $news->getUid(),
            $news->getSku(),
            $news->getTitle(),
            $news->getPrice(),
            $taxClasses[$news->getTaxClassId()],
            $quantity,
            $news->isNetPrice(),
            null
        );

        $product->setIsVirtualProduct(true);

        return $product;
    }
}
