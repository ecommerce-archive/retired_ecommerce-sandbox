<?php

namespace Sandbox\MainBundle\Product\VariableProduct;

use Doctrine\Common\Collections\ArrayCollection;


class CartItemOptions extends ArrayCollection
{
    static public $allowedKeys = array('size', 'length');


    /**
     * Constructor.
     *
     * @param array $elements
     * @param bool  $throwException
     * @throws \InvalidArgumentException
     */
    public function __construct(array $elements = array(), $throwException = false, $remove = true)
    {
        foreach ($elements as $key => $value) {
            if (!in_array($key, self::$allowedKeys)) {
                if ($throwException) {
                    throw new \InvalidArgumentException(sprintf('Unknown option %s', $key));
                } elseif ($remove) {
                    unset($elements[$key]);
                }
            }
        }

        parent::__construct($elements);
    }

    /**
     * Create from object
     * @parm array
     */
    static public function createFromArray(array $options)
    {
        $instance = new self();

        if (isset($options['size'])) {
            $instance->setSize($options['size']);
        }
        if (isset($options['length'])) {
            $instance->setLength($options['length']);
        }

        return $instance;
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $value)
    {
        if (!in_array($key, self::$allowedKeys)) {
            throw new \InvalidArgumentException(sprintf('Unknown option %s', $key));
        }

        parent::set($key, $value);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function add($value)
    {
        throw new \BadFunctionCallException();
    }

    /**
     * @param string $size
     */
    public function setSize($size)
    {
        $this->set('size', $size);
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->get('size');
    }

    /**
     * @param int $length
     */
    public function setLength($length)
    {
        $this->set('length', $length);
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->get('length');
    }
}
