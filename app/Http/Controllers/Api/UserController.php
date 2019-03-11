<?php

namespace App\Http\Controllers\Api;

use App\Http\Transformers\PaginatorTransformer;
use App\Models\User;
use App\Models\Account;
use App\Models\UserRol;
use App\Http\InputRules\UserRules;
use App\Repository\UserRepository;
use App\Repository\AccountRepository;
use Illuminate\Http\Request;
use App\Http\Transformers\UserTransformer;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class to handle user requests
 */
class UserController extends ApiController
{
    /**
     * Construct the controller
     *
     * @param UserTransformer $transformer
     */
    public function __construct(UserTransformer $transformer)
    {
        parent::__construct();

        $this->transformer = $transformer;
    }

    /**
     * Create an user
     * @param  Request $request Request
     * @return Response
     */
    public function postCollection(Request $request): Response
    {
        $this->verify($request, UserRules::postRules());

        //$account = $request->get('authenticated_account')->getCustomer()->id;
        $account = AccountRepository::add($request->all());

        // Send necessary fields for new user
        $user = UserRepository::add($request->all() + ['account_id' => $account->id]);

        UserRol::create(['user_id' => $user->id, 'rol_id' => $request['rol_id'], 'created_at' => gmdate('Y-m-d H:i:s')]);

        return $this->respond([
            'data' => [
                'user' => $this->transformer->transform($user),
            ],
        ]);
    }

    /**
     * List users
     * @param  Request $request Request
     * @return Response
     */
    public function getCollection(Request $request): Response
    {
        $paginator = User::filterBy($request->all());

        return $this->respond([
            'data' => PaginatorTransformer::transform($paginator, 'users', $this->transformer)
        ]);
    }

    /**
     * Update an user
     * @param  Request  $request  Request
     * @param  string  $userUuid   User uuid
     * @return Response
     */
    public function patchResource(Request $request, string $userUuid): Response
    {
        $currentUser = User::where('uuid', $userUuid)->firstOrFail();

        $this->verify($request, UserRules::updateRules());

        //$customerId = $request->get('authenticated_user')->getCustomer()->id;

        $user = UserRepository::update($userUuid, $request->all());

        return $this->respond([
            'data' => [
                'user' => $this->transformer->transform($user),
            ],
        ]);
    }

    /**
     * Delete an user
     * @param  Request  $request  Request
     * @param  string   $userUuid   User uuid
     * @return Response
     */
    public function deleteResource(Request $request, string $userUuid): Response
    {
        UserRepository::delete($userUuid);

        return $this->respond([
            'data' => [],
        ]);
    }

    /**
     * Get an user
     * @param  Request   $request  Request
     * @param  integer   $userUuid   User uuid
     * @return Response
     */
    public function getResource(Request $request, $userUuid): Response
    {
        $user = $this->transformer->transform(UserRepository::get($userUuid));

        return $this->respond([
            'data' => [
                'user' => $user,
            ],
        ]);
    }
}
