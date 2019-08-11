<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Answer;
use App\Models\User;
use App\Models\Question;
use App\Repository\AnswerRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Transformers\AnswerTransformer;
use App\Http\Transformers\PaginatorTransformer;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\ApiController;
use App\Enum\TypeQuestion;

/**
 * Class to handle answer requests
 */
class AnswerController extends ApiController
{
    /**
     * Construct the controller
     *
     * @param AnswerTransformer $transformer
     */
    public function __construct(AnswerTransformer $transformer)
    {
        parent::__construct();

        $this->transformer = $transformer;
    }

    /**
     * Create a answer
     * @param  Request $request Request
     * @return Response
     */
    public function postCollection(Request $request, string $userId): Response
    {
        $this->verify($request, [
            'type' => ['required', 'string', Rule::in(TypeQuestion::ALLOWED)],
            'answer' => 'required',
            'question_id' => 'required'
        ]);

        $user = User::where('id', $userId)->firstOrFail();

        $question = Question::where('id', $request['question_id'])->firstOrFail();

        $answer = AnswerRepository::create($request->all(), $user->id);

        return $this->respond([
            'data' => [
                'answer' => $this->transformer->transform($answer),
            ],
        ]);
    }

    /**
     * List answer
     * @param  Request $request Request
     * @return Response
     */
    public function getCollection(Request $request): Response
    {
        $answer = Answer::filterBy($request->all());

        return $this->respond([
            'data' => PaginatorTransformer::transform($answer, 'answer', $this->transformer),
        ]);
    }

    /**
     * Update a answer
     * @param  Request  $request  Request
     * @param  string  $userUuid   Answer id
     * @return Response
     */
    public function patchResource(Request $request, string $answerUuid): Response
    {
        $currentAnswer = Answer::where('uuid', $answerUuid)->firstOrFail();

        $this->verify($request, [
            'type' => ['required', 'string', Rule::in(TypeQuestion::ALLOWED)],
            'answer' => 'required'
        ]);

        $answers = AnswerRepository::update($answerUuid, $request->all());

        return $this->respond([
            'data' => [
                'answer' => $answers,
            ],
        ]);
    }

    /**
     * Get a answer
     * @param  Request   $request  Request
    * @param  string   $answerUuid   Answer uuid
     * @return Response
     */
    public function getResource(Request $request, $answerUuid): Response
    {
        $answer = $this->transformer->transform(AnswerRepository::get($answerUuid));

        return $this->respond([
            'data' => [
                'answer' => $answer,
            ],
        ]);
    }
}
