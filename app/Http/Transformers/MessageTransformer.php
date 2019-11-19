<?php
namespace App\Http\Transformers;

/**
 * User tranaformer
 */
class MessageTransformer extends AbstractTransformer
{
    /**
     * {@inheritDoc
     */
    public function transform($item, array $options = [])
    {
        return [
            'id' => $item->id,
            'uuid' => $item->uuid,
            'unit' => $item->unit,
            'user_sender' => $item->user,
            'title' => $item->title,
            'body' => $item->body,
            'created_at' => $item->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $item->updated_at !== null ? $item->updated_at->format('Y-m-d H:i:s') : null,
        ];
    }
}