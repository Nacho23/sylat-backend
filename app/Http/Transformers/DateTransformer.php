<?php
namespace App\Http\Transformers;

/**
 * User tranaformer
 */
class DateTransformer extends AbstractTransformer
{
    /**
     * {@inheritDoc
     */
    public function transform($item, array $options = [])
    {
        return [
            'id' => $item->id,
            'date' => $item->date,
        ];
    }
}