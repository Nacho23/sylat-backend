<?php
namespace App\Http\Transformers;

/**
 * User tranaformer
 */
class UnitTransformer extends AbstractTransformer
{
    /**
     * {@inheritDoc
     */
    public function transform($item, array $options = [])
    {
        return [
            'id' => $item->id,
            'uuid' => $item->uuid,
            'name' => $item->name,
            'code' => $item->code,
            'created_at' => $item->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $item->updated_at !== null ? $item->updated_at->format('Y-m-d H:i:s') : null,
            'deleted_at' => $item->deleted_at !== null ? $item->deleted_at->format('Y-m-d H:i:s') : null,
        ];
    }
}