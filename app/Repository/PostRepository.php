<?php

namespace App\Repository;

use App\Exceptions\Api\ResourceAlreadyExistsException;
use App\Exceptions\Api\InvalidParametersException;
use App\Exceptions\Api\ResourceAlreadyHasContextException;
use App\Models\Post;
use App\Models\Date;
use App\Models\Category;

class PostRepository
{
    /**
     * Create a new post
     *
     * @param  string  $unitUuid   User uuid
     * @param  array   $data     User data
     * @return Post
     */
    public static function create(array $data, string $unitId): Post
    {
        $category = Category::where('id', $data['category_id'])->firstOrFail();

        $newData = [
            'title' => $data['title'],
            'body' => $data['body'],
            'category_id' => $data['category_id'],
            'unit_id' => $unitId,
            'user_receiver_id' => $data['user_receiver_id'],
            'user_sender_id' => $data['user_id'],
            'is_important' => $data['is_important'],
            'created_at' => gmdate('Y-m-d H:i:s'),
        ];


        $post = Post::create($newData);

        return $post;
    }

    /**
     * update a post
     *
     * @param  string  $postUuid   Post id
     * @param  array   $data     Post data
     * @return Post
     */
    public static function update(string $postUuid, array $data): Post
    {
        $post = Post::where('uuid', $postUuid)->first();

        $newData = [
            'title' => $data['title'],
            'body' => $data['body'],
            'category_id' => $data['category_id'],
            'is_important' => $data['is_important'],
            'updated_at' => gmdate('Y-m-d H:i:s'),
        ];

        $post->update($newData);

        return $post;
    }

    /**
     * Get an existing post
     *
     * @param  string $postUuid Post is
     * @return Post
     */
    public static function get(string $postUuid): Post
    {
        return Post::where('uuid', $postUuid)->firstOrFail();
    }
}
