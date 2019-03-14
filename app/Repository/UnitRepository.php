<?php

namespace App\Repository;

use App\Exceptions\Api\ResourceAlreadyExistsException;
use App\Exceptions\Api\InvalidParametersException;
use App\Models\Unit;

class UnitRepository
{
    /**
     * Updates an unit
     *
     * @param  string  $unitUuid   Unit uuid
     * @param  array   $data     Unit data
     * @return Unit
     */
    public static function update(string $unitUuid, array $data): Unit
    {
        $unit = Unit::where('uuid', $unitUuid)->first();

        if (Unit::where('uuid', '<>', $unit->uuid)->where('code', $data['code'])->first())
        {
            throw new ResourceAlreadyExistsException("code " . $data['code'], ['code' => 'code must be unique']);
        }

        $unitData = [
            'name' => $data['name'],
            'code' => $data['code'],
            'updated_at' => gmdate('Y-m-d H:i:s'),
        ];

        $unit->update($unitData);

        return $unit;
    }

    /**
     * Delete an existing unit
     *
     * @param  string $unitUuid Unit uuid
     * @return void
     */
    public static function delete(string $unitUuid)
    {
        $unit = Unit::where('uuid', $unitUuid)->where('deleted_at', null)->firstOrFail();
        $unit->deleted_at = gmdate('Y-m-d H:i:s');
        $unit->save();
    }

    /**
     * Get an existing unit
     *
     * @param  string $unitUuid Unit uuid
     * @return Unit
     */
    public static function get(string $unitUuid): Unit
    {
        return Unit::where('uuid', $unitUuid)->where('deleted_at', null)->firstOrFail();
    }
}
