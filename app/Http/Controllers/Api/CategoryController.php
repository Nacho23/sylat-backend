<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class to handle category requests
 */
class CategoryController extends ApiController
{
    /**
     * Create an category
     * @param  Request $request Request
     * @return Response
     */
    public function postCollection(Request $request): Response
    {
        $this->verify($request, [
            'name' => 'string|required',
            'unit_id' => 'numeric|required',
        ]);

        $category = Category::create($request->all() + ['created_at' => gmdate('Y-m-d H:i:s')]);

        return $this->respond([
            'data' => [
                'category' => $category,
            ],
        ]);
    }

    /**
     * List units
     * @param  Request $request Request
     * @return Response
     */
    public function getCollection(Request $request): Response
    {
        $categories = Category::filterBy($request->all());

        return $this->respond([
            'data' => [
                'categories' => $categories
            ]
        ]);
    }

    /**
     * Delete a category
     * @param  Request  $request  Request
     * @param  string   $unitId   Category id
     * @return Response
     */
    public function deleteResource(Request $request, string $unitId): Response
    {
        $category = Category::where('id', $unitId)->where('deleted_at', null)->firstOrFail();
        $category->delete();

        return $this->respond([
            'data' => [],
        ]);
    }

}
