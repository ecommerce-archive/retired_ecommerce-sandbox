<?php

namespace Sandbox\MainBundle\Product\Handler;

use Ecommerce\Bundle\CoreBundle\Doctrine\Orm\CartItem;
use Ecommerce\Bundle\CoreBundle\Doctrine\Orm\ProductReference;
use Ecommerce\Bundle\CoreBundle\Doctrine\Phpcr\Product as ProductInterface;
use Ecommerce\Bundle\CoreBundle\Product\CartHandlerInterface;
use Ecommerce\Bundle\CoreBundle\Product\CartItemValidatorInterface;
use Ecommerce\Bundle\CoreBundle\Product\ProductHandlerInterface;

use Sandbox\MainBundle\Product\VariableProduct\CartItemOptions;
use Sandbox\MainBundle\Product\VariableProduct\CartItemValidator;

class ProductWithOptionsHandler implements ProductHandlerInterface
{
    /**
     * Constructor.
     */
    public function __construct(ProductManager $productManager = null, CartHandler $cartHandler = null, CartItemValidator $validator = null)
    {
        $this->productManager = $productManager;
        $this->cartHandler    = $cartHandler;
        $this->validator      = $validator;
    }

    /**
     * @param ProductInterface $product
     * @return bool
     */
    public function supports(ProductInterface $product)
    {
        return true;
    }

    /**
     * @param ProductInterface $product
     * @param array|null       $options
     * @return CartItem|null
     */
    public function createCartItem(ProductInterface $product, $options)
    {
        $cartItem = new CartItem();
        $cartItem->setProduct($product->getProductReference());
        $cartItem->setOptions($options);

        $cartItemValidator = new CartItemValidator();
        if (!$cartItemValidator->isValid($cartItem)) {
            return null;
        }

        return $cartItem;
    }

    /**
     * @param ProductInterface $product
     * @return CartHandlerInterface
     */
    public function getCartHandler(ProductInterface $product)
    {
        return $this->cartHandler;
    }

    /**
     * @param CartItem $cartItem
     * @return CartItemValidatorInterface
     */
    public function getCartItemValidator(CartItem $cartItem)
    {
        // TODO: Implement getCartItemValidator() method.
    }

}
