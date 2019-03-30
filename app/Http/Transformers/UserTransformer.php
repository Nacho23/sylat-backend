<?php
namespace App\Http\Transformers;

use App\Models\User;
use App\Models\UserRol;

/**
 * User tranaformer
 */
class UserTransformer extends AbstractTransformer
{
    /**
     * {@inheritDoc
     */
    public function transform($item, array $options = [])
    {
        $userRol = UserRol::where('user_id', $item->id)->firstOrFail();

        if ($userRol->rol_id === 4)
        {
            $userRelationship = $item->user_relationships_godfather;
        }
        else if ($userRol->rol_id === 3)
        {
            $userRelationship = $item->user_relationships_godson;
        }
        else
        {
            $userRelationship = null;
        }

        return [
            'id' => $item->id,
            'rol_id' => $userRol->rol_id,
            'uuid' => $item->uuid,
            'first_name' => $item->first_name,
            'last_name' => $item->last_name,
            'email' => $item->email,
            'rut' => $item->rut,
            'rut_dv' => $item->rut_dv,
            'unit' => $item->unit,
            'address_street' => $item->address_street,
            'address_number' => $item->address_number,
            'addess_department' => $item->address_department,
            'address_town' => $item->address_town,
            'phone_landline' => $item->phone_landline,
            'phone_mobile' => $item->phone_mobile,
            'account_id' => $item->account_id,
            'created_at' => $item->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $item->updated_at !== null ? $item->updated_at->format('Y-m-d H:i:s') : null,
            'deleted_at' => $item->deleted_at !== null ? $item->deleted_at->format('Y-m-d H:i:s') : null,
            'is_admin' => (int)$item->is_admin,
            'user_relationship' => $userRelationship ? $userRelationship : null
        ];
    }
}