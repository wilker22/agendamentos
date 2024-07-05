<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Unit extends MyBaseEntity
{
    protected $casts = [
        'services' => '?json-array',
    ];
}
