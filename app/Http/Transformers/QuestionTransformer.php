<?php
namespace App\Http\Transformers;

use App\Http\Transformers\DateTransformer;
use App\Models\Date;

/**
 * User tranaformer
 */
class QuestionTransformer extends AbstractTransformer
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
            'description' => $item->description,
            'unit_id' => $item->unit_id,
            'is_active' => $item->is_active,
            'type' => $item->type,
            'dates' => Date::where('question_id', $item->id)->get(),
            'created_at' => $item->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $item->updated_at !== null ? $item->updated_at->format('Y-m-d H:i:s') : null,
        ];
    }
}