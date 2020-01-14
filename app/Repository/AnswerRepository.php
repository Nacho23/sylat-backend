<?php

namespace App\Repository;

use App\Models\Answer;

class AnswerRepository
{
    /**
     * Create a new answer
     *
     * @param  string  $unitUuid   User uuid
     * @param  array   $data     User data
     * @return Answer
     */
    public static function create(array $data, string $userId): Answer
    {
        $newData = [
            'type' => $data['type'],
            'answer' => $data['answer'],
            'user_id' => $userId,
            'date' => $data['date'],
            'question_id' => $data['question_id'],
            'created_at' => gmdate('Y-m-d H:i:s'),
        ];

        $answer = Answer::create($newData);

        return $answer;
    }

    /**
     * update a answer
     *
     * @param  string  $answerUuid   Answer id
     * @param  array   $data     Answer data
     * @return Answer
     */
    public static function update(string $answerUuid, array $data): Answer
    {
        $answer = Answer::where('uuid', $answerUuid)->first();

        $newData = [
            'type' => $data['type'],
            'answer' => $data['answer'],
            'updated_at' => gmdate('Y-m-d H:i:s'),
        ];

        $answer->update($newData);

        return $answer;
    }

    /**
     * Get an existing answer
     *
     * @param  string $answerUuid Answer uuid
     * @return Answer
     */
    public static function get(string $answerUuid): Answer
    {
        return Answer::where('uuid', $answerUuid)->firstOrFail();
    }
}
