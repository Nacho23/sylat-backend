<?php
namespace App\Http\Transformers;

use App\Http\Transformers\DateTransformer;
use App\Models\Date;

/**
 * User tranaformer
 */
class NewsTransformer extends AbstractTransformer
{
    /**
     * {@inheritDoc
     */
    public function transform($item, array $options = [])
    {
        return [
            'id' => $item->id,
            'uuid' => $item->uuid,
            'description' => $item->description,
            'unit_id' => $item->unit_id,
            'is_active' => $item->is_active,
            'date' => Date::select('date')->where('id', $item->date_id)->get()[0]->date->format('Y-m-d'),
            'created_at' => $item->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $item->updated_at !== null ? $item->updated_at->format('Y-m-d H:i:s') : null,
        ];
    }
}
