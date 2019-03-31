<?php

namespace App\Http\Controllers\Api\Unit;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\ApiController;

/**
 * Class to handle question requests
 */
class ImportController extends ApiController
{
    /**
     * Create a question
     * @param  Request $request Request
     * @return Response
     */
    public function postCollection(Request $request, string $unitId): Response
    {
        $this->verify($request, [
            'file' => 'required',
        ]);
    }
}
