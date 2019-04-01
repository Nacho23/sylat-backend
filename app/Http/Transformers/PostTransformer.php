<?php
namespace App\Http\Transformers;

/**
 * Post tranaformer
 */
class PostTransformer extends AbstractTransformer
{
    /**
     * {@inheritDoc
     */
    public function transform($item, array $options = [])
    {
        return [
            'id' => $item->id,
            'uuid' => $item->uuid,
            'title' => $item->title,
            'body' => $item->body,
            'category' => $item->category,
            'user_sender' => $item->user_sender,
            'user_receiver' => $item->user_receiver,
            'is_important' => $item->is_important,
            'created_at' => $item->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $item->updated_at !== null ? $item->updated_at->format('Y-m-d H:i:s') : null,
        ];
    }
}