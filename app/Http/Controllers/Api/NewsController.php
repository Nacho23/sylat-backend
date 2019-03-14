<?php

namespace App\Http\Controllers\Api;

use App\Models\News;
use App\Repository\NewsRepository;
use Illuminate\Http\Request;
use App\Http\Transformers\NewsTransformer;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class to handle news requests
 */
class NewsController extends ApiController
{
    /**
     * Construct the controller
     *
     * @param NewsTransformer $transformer
     */
    public function __construct(NewsTransformer $transformer)
    {
        parent::__construct();

        $this->transformer = $transformer;
    }

    /**
     * Create a new
     * @param  Request $request Request
     * @return Response
     */
    public function postCollection(Request $request): Response
    {
        $this->verify($request, [
            'description' => 'string|required',
            'date' => 'required',
            'unit_id' => 'numeric|required'
        ]);

        $news = NewsRepository::create($request->all());

        return $this->respond([
            'data' => [
                'news' => $news,
            ],
        ]);
    }

    /**
     * List news
     * @param  Request $request Request
     * @return Response
     */
    public function getCollection(Request $request): Response
    {
        $news = News::filterBy($request->all());

        return $this->respond([
            'data' => $news,
        ]);
    }

    /**
     * Update a new
     * @param  Request  $request  Request
     * @param  string  $userUuid   News uuid
     * @return Response
     */
    public function patchResource(Request $request, string $newsUuid): Response
    {
        $currentNews = News::where('uuid', $newsUuid)->firstOrFail();

        $this->verify($request, [
            'description' => 'string|required',
            'date' => 'required',
            'unit_id' => 'numeric|required',
            'date_id' => 'required',
        ]);

        //$customerId = $request->get('authenticated_user')->getCustomer()->id;

        $news = NewsRepository::update($newsUuid, $request->all());

        return $this->respond([
            'data' => [
                'new' => $news,
            ],
        ]);
    }

    /**
     * Delete a new
     * @param  Request  $request  Request
     * @param  string   $newsUuid   News uuid
     * @return Response
     */
    public function deleteResource(Request $request, string $newsUuid): Response
    {
        NewsRepository::delete($newsUuid);

        return $this->respond([
            'data' => [],
        ]);
    }

    /**
     * Get a news
     * @param  Request   $request  Request
     * @param  integer   $newsUuid   News uuid
     * @return Response
     */
    public function getResource(Request $request, $newsUuid): Response
    {
        $news = $this->transformer->transform(NewsRepository::get($newsUuid));

        return $this->respond([
            'data' => [
                'news' => $news,
            ],
        ]);
    }
}
