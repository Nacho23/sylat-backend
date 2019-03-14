<?php

namespace App\Repository;

use App\Exceptions\Api\ResourceAlreadyExistsException;
use App\Exceptions\Api\InvalidParametersException;
use App\Models\News;
use App\Models\Date;

class NewsRepository
{
    /**
     * Create a new
     *
     * @param  string  $unitUuid   Unit uuid
     * @param  array   $data     Unit data
     * @return News
     */
    public static function create(array $data): News
    {
        $date = Date::create(['date' => $data['date']]);

        $newData = [
            'description' => $data['description'],
            'unit_id' => $data['unit_id'],
            'date_id' => $date->id,
            'created_at' => gmdate('Y-m-d H:i:s'),
        ];

        $news = News::create($newData);

        return $news;
    }

    /**
     * update a new
     *
     * @param  string  $newsUuid   News uuid
     * @param  array   $data     News data
     * @return News
     */
    public static function update(string $newsUuid, array $data): News
    {
        $news = News::where('uuid', $newsUuid)->first();

        $date = Date::where('id', $data['date_id'])->first();

        $date->update(['date' => $data['date']]);

        $newData = [
            'description' => $data['description'],
            'unit_id' => $data['unit_id'],
            'date_id' => $date->id,
            'updated_at' => gmdate('Y-m-d H:i:s'),
        ];

        $news->update($newData);

        return $news;
    }

    /**
     * Delete an existing news
     *
     * @param  string $newsUuid news uuid
     * @return void
     */
    public static function delete(string $newsUuid)
    {
        $news = News::where('uuid', $newsUuid)->where('deleted_at', null)->firstOrFail();
        $news->deleted_at = gmdate('Y-m-d H:i:s');
        $news->save();
    }

    /**
     * Get an existing news
     *
     * @param  string $newsUuid News uuid
     * @return News
     */
    public static function get(string $newsUuid): News
    {
        return News::where('uuid', $newsUuid)->where('deleted_at', null)->firstOrFail();
    }
}
