<?php

namespace App\Libraries;

use App\Models\UnitModel;

class UnitService extends MyBaseService
{
    public function renderUnits(): string
    {
        $units = model(UnitModel::class)->orderBy('name', 'ASC')->findAll();
    }
}
