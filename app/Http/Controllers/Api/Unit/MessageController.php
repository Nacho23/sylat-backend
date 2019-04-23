<?php

namespace App\Http\Controllers\Api\Unit;

use App\Models\Message;
use App\Models\Unit;
use App\Repository\MessageRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Transformers\MessageTransformer;
use App\Http\Transformers\PaginatorTransformer;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\ApiController;

/**
 * Class to handle message requests
 */
class MessageController extends ApiController
{
    /**
     * Construct the controller
     *
     * @param MessageTransformer $transformer
     */
    public function __construct(MessageTransformer $transformer)
    {
        parent::__construct();

        $this->transformer = $transformer;
    }

    /**
     * Create a message
     * @param  Request $request Request
     * @return Response
     */
    public function postCollection(Request $request, string $unitUuid): Response
    {
        $this->verify($request, [
            'title' => 'string|required',
            'body' => 'string|required',
            'user_sender_id' => 'string|required',
        ]);

        $unit = Unit::where('uuid', $unitUuid)->firstOrFail();

        $message = MessageRepository::create($request->all(), $unit->id);

        return $this->respond([
            'data' => [
                'message' => $this->transformer->transform($message),
            ],
        ]);
    }

    /**
     * List messages
     * @param  Request $request Request
     * @return Response
     */
    public function getCollection(Request $request, string $unitId): Response
    {
        $unit = Unit::where('id', $unitId)->firstOrFail();

        $message = Message::filterBy($request->all() + ['unit_id' => $unit->id]);

        return $this->respond([
            'data' => PaginatorTransformer::transform($message, 'messages', $this->transformer),
        ]);
    }

    /**
     * Get a message
     * @param  Request   $request  Request
    * @param  string   $messageId   Message id
     * @return Response
     */
    public function getResource(Request $request, $messageId): Response
    {
        $message = $this->transformer->transform(MessageRepository::get($messageId));

        return $this->respond([
            'data' => [
                'message' => $message,
            ],
        ]);
    }
}
