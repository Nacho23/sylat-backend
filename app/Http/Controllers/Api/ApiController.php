<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Util\VerifyTrait;

class ApiController extends Controller
{
    use VerifyTrait;
    /**
     * Api construct
     */
    public function __construct()
    {
        \App::setLocale('es');
    }

    /**
     * Decorate data as a JSON response
     *
     * @param array   $data  Data to respond
     * @param integer $code  HTTP status Code
     * @return JsonResponse
     */
    public function respond(array $data, int $code = 200) : JsonResponse
    {
        return new JsonResponse($data, $code);
    }
}
