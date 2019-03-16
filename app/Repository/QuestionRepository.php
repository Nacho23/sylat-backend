<?php

namespace App\Repository;

use App\Exceptions\Api\ResourceAlreadyExistsException;
use App\Exceptions\Api\InvalidParametersException;
use App\Exceptions\Api\ResourceAlreadyHasContextException;
use App\Models\Question;
use App\Models\Date;

class QuestionRepository
{
    /**
     * Create a new
     *
     * @param  string  $unitUuid   Unit uuid
     * @param  array   $data     Unit data
     * @return Question
     */
    public static function create(array $data, string $unitId): Question
    {
        $newData = [
            'description' => $data['description'],
            'unit_id' => $unitId,
            'type' => $data['type'],
            'created_at' => gmdate('Y-m-d H:i:s'),
        ];

        $question = Question::create($newData);

        for ($i = 0; $i < count($data['date']); $i++)
        {
            Date::create(['date' => $data['date'][$i], 'question_id' => $question->id]);
        }

        return $question;
    }

    /**
     * update a question
     *
     * @param  string  $questionId   Question id
     * @param  array   $data     Question data
     * @return Question
     */
    public static function update(string $questionId, array $data): Question
    {
        $question = Question::where('id', $questionId)->first();

        $dates = Date::where('question_id', $questionId)->get();

        foreach($dates as $date)
        {
            $dateToDelete = Date::where('id', $date['id'])->firstOrFail();
            $dateToDelete->delete();
        }

        for ($i = 0; $i < count($data['date']); $i++)
        {
            Date::create(['date' => $data['date'][$i], 'question_id' => $question->id]);
        }

        $newData = [
            'description' => $data['description'],
            'type' => $data['type'],
            'updated_at' => gmdate('Y-m-d H:i:s'),
        ];

        $question->update($newData);

        return $question;
    }

    /**
     * Delete an existing news
     *
     * @param  string $questionId question uuid
     * @return void
     */
    public static function delete(string $questionId)
    {
        $question = Question::where('id', $questionId)->firstOrFail();

        $questionProperties = $question->question_properties;

        if(count($questionProperties) !== 0)
        {
            throw new ResourceAlreadyHasContextException($question->description, "Propiedades asociadas");
        }

        //TODO : ver si la pregunta tien respuestas asociadas, si es asi, lanzar exception

        $question->delete();
    }

    /**
     * Get an existing question
     *
     * @param  string $questionId Question is
     * @return Question
     */
    public static function get(string $questionId): Question
    {
        return Question::where('id', $questionId)->firstOrFail();
    }
}
