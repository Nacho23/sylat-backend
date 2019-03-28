<?php

namespace App\Repository;

use App\Exceptions\Api\ResourceAlreadyExistsException;
use App\Exceptions\Api\InvalidParametersException;
use App\Models\User;
use App\Models\UserRelationship;
/**
 * Class to handle Users
 * @author Gustavo Delgado <gustavo@onecore.cl>
 */
class UserRepository
{
    /**
     * Creates a new user
     *
     * @param  array $data  User data
     * @return User
     */
    public static function add(array $data): User
    {
        // Verify that email already exist
        $user = User::findByEmail($data['email']);

        if ($user)
        {
            throw new ResourceAlreadyExistsException("email " . $user->email, ['email' => 'email must be unique']);
        }

        // Password encryption
        $data['password'] = User::hashPassword($data['rut']);

        return User::create($data + ['created_at' => gmdate('Y-m-d H:i:s')]);
    }

    /**
     * Updates an user
     *
     * @param  string  $userUuid   User uuid
     * @param  array   $data     User data
     * @return User
     */
    public static function update(string $userUuid, array $data): User
    {
        $user = User::where('uuid', $userUuid)->first();

        if (User::where('uuid', '<>', $user->uuid)->where('email', $data['email'])->first())
        {
            throw new ResourceAlreadyExistsException("email " . $data['email'], ['email' => 'email must be unique']);
        }

        if (User::where('uuid', '<>', $user->uuid)->where('rut', $data['rut'])->first())
        {
            throw new ResourceAlreadyExistsException("rut " . $data['rut'], ['rut' => 'rut must be unique']);
        }

        if ($data['godfatherUuid'])
        {
            $userRelationship = UserRelationship::where('user_godson_id', $user->id)->first();

            $godfatherUser = User::where('id', $data['godfatherUuid'])->firstOrFail();

            if ($userRelationship)
            {
                $userRelationship->update(['user_godfather_id' => $godfatherUser->id, 'update_at' => gmdate('Y-m-d H:i:s')]);
            }
            else
            {
                UserRelationship::create(['user_godfather_id' => $godfatherUser->id, 'user_godson_id' => $user->id, 'created_at' => gmdate('Y-m-d H:i:s')]);
            }
        }
        else
        {
            $userRelationship = UserRelationship::where('user_godson_id', $user->id)->first();

            if ($userRelationship)
            {
                $userRelationship->delete();
            }
        }

        $userData = [
            'rut' => $data['rut'],
            'rut_dv' => $data['rut_dv'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_landline' => array_key_exists('phone_landline', $data) ? $data['phone_landline'] : null,
            'phone_mobile' => array_key_exists('phone_mobile', $data) ? $data['phone_mobile'] : null,
            'updated_at' => gmdate('Y-m-d H:i:s'),
        ];

        $user->update($userData);

        return $user;
    }

    /**
     * Update password an user
     *
     * @param  User   $user     User
     * @param  array   $data     User data
     * @return User
     */
    public static function updatePassword(User $user, array $data): User
    {
        if(!password_verify($data['old_password'], $user->password))
        {
            throw new InvalidParametersException([
                'old_password' => 'Incorrect password'
            ]);
        }

        $passwordEncryp = User::hashPassword($data['new_password']);

        $user->update(['password' => $passwordEncryp]);

        return $user;
    }

    /**
     * Delete an existing user
     *
     * @param  string $userUuid User uuid
     * @return void
     */
    public static function delete(string $userUuid)
    {
        $user = User::where('uuid', $userUuid)->where('deleted_at', null)->firstOrFail();
        $user->deleted_at = gmdate('Y-m-d H:i:s');
        $user->save();
    }

    /**
     * Get an existing user
     *
     * @param  string $userUuid User uuid
     * @return User
     */
    public static function get(string $userUuid): User
    {
        return User::where('uuid', $userUuid)->where('deleted_at', null)->firstOrFail();
    }
}
