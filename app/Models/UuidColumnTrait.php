<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;

trait UuidColumnTrait
{
    /**
     *  {@inheritDoc}
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model)
        {
            $model->uuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, (string)mt_rand(10,9999999999))->toString();
        });
    }
}