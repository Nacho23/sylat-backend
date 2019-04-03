<?php

namespace App\Http\Controllers\Api\Unit;

use App\Models\Post;
use App\Models\User;
use App\Repository\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Transformers\PostTransformer;
use App\Http\Transformers\PaginatorTransformer;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\ApiController;

/**
 * Class to handle question requests
 */
class PostController extends ApiController
{
    /**
     * Construct the controller
     *
     * @param PostTransformer $transformer
     */
    public function __construct(PostTransformer $transformer)
    {
        parent::__construct();

        $this->transformer = $transformer;
    }

    /**
     * Create a post
     * @param  Request $request Request
     * @return Response
     */
    public function postCollection(Request $request, string $unitId): Response
    {
        $this->verify($request, [
            'title' => 'string|required',
            'body' => 'string|required',
            'category_id' => 'required',
            'user_uuid' => 'required',
            'is_important' => 'required',
            'user_receiver_id' => 'required',
        ]);

        $userSender = User::where('uuid', $request['user_uuid'])->firstOrFail();

        $post = PostRepository::create($request->all() + ['user_id' => $userSender->id], $unitId);

        return $this->respond([
            'data' => [
                'post' => $this->transformer->transform($post),
            ],
        ]);
    }

    /**
     * List post
     * @param  Request $request Request
     * @return Response
     */
    public function getCollection(Request $request, string $unitId): Response
    {
        $post = Post::filterBy($request->all() + ['unit_id' => $unitId]);

        return $this->respond([
            'data' => PaginatorTransformer::transform($post, 'posts', $this->transformer),
        ]);
    }

    /**
     * Update a post
     * @param  Request  $request  Request
     * @param  string  $userUuid   Post id
     * @return Response
     */
    public function patchResource(Request $request, string $postUuid): Response
    {
        $currentPost = Post::where('uuid', $postUuid)->firstOrFail();

        $this->verify($request, [
            'title' => 'string|required',
            'body' => 'string|required',
            'category_id' => 'required',
        ]);

        $posts = PostRepository::update($postUuid, $request->all());

        return $this->respond([
            'data' => [
                'post' => $posts,
            ],
        ]);
    }

    /**
     * Get a post
     * @param  Request   $request  Request
    * @param  string   $postUuid   Post uuid
     * @return Response
     */
    public function getResource(Request $request, $postUuid): Response
    {
        $post = $this->transformer->transform(PostRepository::get($postUuid));

        return $this->respond([
            'data' => [
                'post' => $post,
            ],
        ]);
    }
}
