<?php

namespace App\Http\Controllers\Api\Unit;

use App\Models\Question;
use App\Models\Unit;
use App\Repository\QuestionRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Transformers\QuestionTransformer;
use App\Http\Transformers\PaginatorTransformer;
use Symfony\Component\HttpFoundation\Response;
use App\Enum\TypeQuestion;
use App\Http\Controllers\Api\ApiController;

/**
 * Class to handle question requests
 */
class QuestionController extends ApiController
{
    /**
     * Construct the controller
     *
     * @param QuestionTransformer $transformer
     */
    public function __construct(QuestionTransformer $transformer)
    {
        parent::__construct();

        $this->transformer = $transformer;
    }

    /**
     * Create a question
     * @param  Request $request Request
     * @return Response
     */
    public function postCollection(Request $request, string $unitId): Response
    {
        $this->verify($request, [
            'description' => 'string|required',
            'type' => ['required', 'string', Rule::in(TypeQuestion::ALLOWED)]
        ]);

        $unit = Unit::where('id', $unitId)->firstOrFail();

        $question = QuestionRepository::create($request->all(), $unit->id);

        return $this->respond([
            'data' => [
                'question' => $this->transformer->transform($question),
            ],
        ]);
    }

    /**
     * List questions
     * @param  Request $request Request
     * @return Response
     */
    public function getCollection(Request $request, string $unitId): Response
    {
        $unit = Unit::where('id', $unitId)->firstOrFail();

        $question = Question::filterBy($request->all() + ['unit_id' => $unit->id]);

        return $this->respond([
            'data' => PaginatorTransformer::transform($question, 'questions', $this->transformer),
        ]);
    }

    /**
     * Update a question
     * @param  Request  $request  Request
     * @param  string  $userId   Question id
     * @return Response
     */
    public function patchResource(Request $request, string $questionId): Response
    {
        $currentQuestion = Question::where('id', $questionId)->firstOrFail();

        $this->verify($request, [
            'description' => 'string|required',
            'type' => ['required', 'string', Rule::in(TypeQuestion::ALLOWED)]
        ]);

        //$customerId = $request->get('authenticated_user')->getCustomer()->id;

        $questions = QuestionRepository::update($questionId, $request->all());

        return $this->respond([
            'data' => [
                'question' => $questions,
            ],
        ]);
    }

    /**
     * Delete a question
     * @param  Request  $request  Request
     * @param  string   $questionId   question id
     * @return Response
     */
    public function deleteResource(Request $request, string $questionId): Response
    {
        QuestionRepository::delete($questionId);

        return $this->respond([
            'data' => [],
        ]);
    }

    /**
     * Get a question
     * @param  Request   $request  Request
    * @param  integer   $questionId   Question id
     * @return Response
     */
    public function getResource(Request $request, $questionId): Response
    {
        $question = $this->transformer->transform(QuestionRepository::get($questionId));

        return $this->respond([
            'data' => [
                'question' => $question,
            ],
        ]);
    }
}
