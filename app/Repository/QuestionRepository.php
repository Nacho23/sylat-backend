<?php

namespace App\Repository;

use App\Models\Question;
use App\Models\Date;
use App\Models\QuestionProperty;
use Illuminate\Support\Facades\DB;

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

        if(array_key_exists('options', $data))
        {
            foreach($data['options'] as $option)
            {
                QuestionProperty::create([
                    'question_id' => $question->id,
                    'property' => $option['property'],
                    'value' => $option['value'],
                    'created_at' => gmdate('Y-m-d H:i:s')
                ]);
            }
        }

        for ($i = 0; $i < count($data['dates']); $i++)
        {
            Date::create(['date' => $data['dates'][$i], 'question_id' => $question->id]);
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

        for ($i = 0; $i < count($data['dates']); $i++)
        {
            Date::create(['date' => $data['dates'][$i], 'question_id' => $question->id]);
        }

        $options = QuestionProperty::where('question_id', $questionId)->get();

        foreach($options as $option)
        {
            $optionToDelete = QuestionProperty::where('id', $option['id'])->firstOrFail();
            $optionToDelete->delete();
        }

        if(array_key_exists('options', $data))
        {
            foreach($data['options'] as $option)
            {
                QuestionProperty::create([
                    'question_id' => $question->id,
                    'property' => $option['property'],
                    'value' => $option['value'],
                    'created_at' => gmdate('Y-m-d H:i:s')
                ]);
            }
        }

        $newData = [
            'description' => $data['description'],
            'type' => $data['type'],
            'is_active' => $data['is_active'],
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
        try
        {
            DB::beginTransaction();

            $question = Question::where('id', $questionId)->firstOrFail();

            $question->question_properties()->delete();

            $question->dates()->delete();

            $question->delete();

            DB::commit();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            throw $e;
        }
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
