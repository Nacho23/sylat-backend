<?php

namespace App\Http\Transformers;
use App\Http\Transformers\TransformerInterface;
use App\Http\Transformers\InflatorTrait;

abstract class AbstractTransformer implements TransformerInterface
{
    use InflatorTrait;

    /**
     * Transforms a collection
     *
     * @param array $items
     * @return void
     */
    public function transformCollection(array $items, array $options = [])
    {
        return array_map(function($item) use ($options)
        {
            return $this->transform($item, $options);
        }, $items);
    }

    /**
     * Transform an item
     *
     * @param mixed $item
     * @param array $options  List of custom options:
     *                         - inflators: List of keys to inflate to the related object.
     * @return void
     */
    public abstract function transform($item, array $options = []);
}