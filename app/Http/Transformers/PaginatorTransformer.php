<?php

namespace App\Http\Transformers;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Transformers\TransformerInterface;

final class PaginatorTransformer
{
    /**
     * Transform the paginator
     *
     * @param LengthAwarePaginator $paginator     Paginator instance
     * @param string               $key           Key context
     * @param TransformerInterface $transformer   Item transformer
     * @param array                $name          List of options (e.g: inflators)
     * @return array
     */
    public static function transform(LengthAwarePaginator $paginator, string $key, TransformerInterface $transformer = null, array $options = []): array
    {
        $items = $paginator->items();

        if ($transformer)
        {
            $items = array_map(function ($item) use ($transformer, $options)
            {
                return $transformer->transform($item, $options);
            }, $items);
        }

        $paginator = $paginator->toArray();
        unset($paginator['data']);

        return [$key => $items, 'pagination' => $paginator];
    }
}