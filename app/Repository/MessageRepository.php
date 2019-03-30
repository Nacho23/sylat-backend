<?php

namespace App\Repository;

use App\Exceptions\Api\ResourceAlreadyExistsException;
use App\Exceptions\Api\InvalidParametersException;
use App\Exceptions\Api\ResourceAlreadyHasContextException;
use App\Models\Message;
use App\Models\Date;

class MessageRepository
{
    /**
     * Create a new
     *
     * @param  string  $unitUuid   Unit uuid
     * @param  array   $data     Unit data
     * @return Message
     */
    public static function create(array $data, string $unitId): Message
    {
        $newData = [
            'title' => $data['title'],
            'body' => $data['body'],
            'user_sender_id' => $data['user_sender_id'],
            'unit_id' => $unitId,
            'created_at' => gmdate('Y-m-d H:i:s'),
        ];

        $message = Message::create($newData);

        return $message;
    }

    /**
     * Get an existing message
     *
     * @param  string $messageId Message is
     * @return Message
     */
    public static function get(string $messageId): Message
    {
        return Message::where('id', $messageId)->firstOrFail();
    }
}
