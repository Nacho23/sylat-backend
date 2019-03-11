<?php
namespace App\Http\Transformers;

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
        return [
            'id' => $item->id,
            'uuid' => $item->uuid,
            'first_name' => $item->first_name,
            'last_name' => $item->last_name,
            'email' => $item->email,
            'rut' => $item->rut,
            'rut_dv' => $item->rut_dv,
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
        ];
    }
}