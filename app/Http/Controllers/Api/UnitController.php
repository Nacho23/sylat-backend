<?php

namespace App\Http\Controllers\Api;

use App\Http\Transformers\PaginatorTransformer;
use App\Models\Unit;
use App\Repository\UnitRepository;
use Illuminate\Http\Request;
use App\Http\Transformers\UnitTransformer;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class to handle unit requests
 */
class UnitController extends ApiController
{
    /**
     * Construct the controller
     *
     * @param UnitTransformer $transformer
     */
    public function __construct(UnitTransformer $transformer)
    {
        parent::__construct();

        $this->transformer = $transformer;
    }

    /**
     * Create an unit
     * @param  Request $request Request
     * @return Response
     */
    public function postCollection(Request $request): Response
    {
        $this->verify($request, [
            'name' => 'string|required',
            'code' => 'string|required',
        ]);

        $unit = UnitRepository::create($request->all());

        return $this->respond([
            'data' => [
                'unit' => $this->transformer->transform($unit),
            ],
        ]);
    }

    /**
     * List units
     * @param  Request $request Request
     * @return Response
     */
    public function getCollection(Request $request): Response
    {
        $paginator = Unit::filterBy($request->all());

        return $this->respond([
            'data' => PaginatorTransformer::transform($paginator, 'units', $this->transformer)
        ]);
    }

    /**
     * Update an unit
     * @param  Request  $request  Request
     * @param  string  $userUuid   Unit uuid
     * @return Response
     */
    public function patchResource(Request $request, string $unitUuid): Response
    {
        $currentUnit = Unit::where('uuid', $unitUuid)->firstOrFail();

        $this->verify($request, [
            'name' => 'string|required',
            'code' => 'string|required',
        ]);

        //$customerId = $request->get('authenticated_user')->getCustomer()->id;

        $unit = UnitRepository::update($unitUuid, $request->all());

        return $this->respond([
            'data' => [
                'unit' => $this->transformer->transform($unit),
            ],
        ]);
    }

    /**
     * Delete an unit
     * @param  Request  $request  Request
     * @param  string   $unitUuid   Unit uuid
     * @return Response
     */
    public function deleteResource(Request $request, string $unitUuid): Response
    {
        UnitRepository::delete($unitUuid);

        return $this->respond([
            'data' => [],
        ]);
    }

    /**
     * Get an unit
     * @param  Request   $request  Request
     * @param  integer   $unitUuid   Unit uuid
     * @return Response
     */
    public function getResource(Request $request, $unitUuid): Response
    {
        $unit = $this->transformer->transform(UnitRepository::get($unitUuid));

        return $this->respond([
            'data' => [
                'unit' => $unit,
            ],
        ]);
    }
}
