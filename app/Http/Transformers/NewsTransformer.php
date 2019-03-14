<?php
namespace App\Http\Transformers;

use App\Http\Transformers\DateTransformer;

/**
 * User tranaformer
 */
class NewsTransformer extends AbstractTransformer
{
    /**
     * @var \App\Http\Transformers\DateTransformer  Date transformer
     */
    protected $dateTransformer;

    public function __construct(DateTransformer $dateTransformer)
    {
        $this->dateTransformer = $dateTransformer;
    }

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
            'date_id' => $item->date_id,
            'created_at' => $item->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $item->updated_at !== null ? $item->updated_at->format('Y-m-d H:i:s') : null,
            'deleted_at' => $item->deleted_at !== null ? $item->deleted_at->format('Y-m-d H:i:s') : null,
        ];
    }
}