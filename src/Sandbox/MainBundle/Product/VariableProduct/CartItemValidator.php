<?php

namespace Sandbox\MainBundle\Product\VariableProduct;

use Ecommerce\Bundle\CoreBundle\Cart\CartItemValidatorInterface;
use Ecommerce\Bundle\CoreBundle\Doctrine\Orm\CartItem;

class CartItemValidator implements CartItemValidatorInterface
{
    /** @var CartItemOptions */
    private $options;

    public function isValid(CartItem $cartItem)
    {
        try {
            $this->options = new CartItemOptions((array)$cartItem->getOptions(), false);

            if (!$this->validateSize()) {
                return false;
            }

            if (!$this->validateLength()) {
                return false;
            }

            $cartItem->setOptions($this->options->toArray());

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function validateSize()
    {
        if (!($size = (int)$this->options->getSize())) {
            return false;
        }

        $sizes = array(36, 38, 40);

        if (!in_array($size, $sizes)) {
            return false;
        }

        return true;
    }

    private function validateLength()
    {
        if (!($length = (int)$this->options->getLength())) {
            return false;
        }

        if ($length !== 5 && $length !== 10) {
            return false;
        }

        return true;
    }
}
