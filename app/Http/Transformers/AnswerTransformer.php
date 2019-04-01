<?php
namespace App\Http\Transformers;

/**
 * Answer tranaformer
 */
class AnswerTransformer extends AbstractTransformer
{
    /**
     * {@inheritDoc
     */
    public function transform($item, array $options = [])
    {
        return [
            'id' => $item->id,
            'uuid' => $item->uuid,
            'type' => $item->type,
            'answer' => $item->answer,
            'user' => $item->user,
            'question_id' => $item->question_id,
            'created_at' => $item->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $item->updated_at !== null ? $item->updated_at->format('Y-m-d H:i:s') : null,
        ];
    }
}