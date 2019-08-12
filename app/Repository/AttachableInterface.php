<?php

namespace App\Repository;

interface AttachableInterface
{
    /**
     * Relation helper
     *
     * @return void
     */
    public function attachments();
}