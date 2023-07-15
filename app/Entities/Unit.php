<?php

namespace App\Entities;

class Unit extends MyBaseEntity
{
    protected $casts = [
        'services'  => '?json-array',
    ];
}
