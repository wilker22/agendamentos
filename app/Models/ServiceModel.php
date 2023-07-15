<?php

namespace App\Models;

use App\Entities\Service;

class ServiceModel extends MyBaseModel
{
    protected $DBGroup          = 'default';
    protected $table            = 'services';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Service::class;
    protected $useSoftDeletes   = false; // vamos excluir o registro
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'active',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    // Validation
    protected $validationRules      = [
        'id'            => 'permit_empty|is_natural_no_zero',
        'name'          => 'required|max_length[69]|is_unique[units.name,id,{id}]',
    ];


    protected $validationMessages   = [
        'name' => [
            'required' => 'Obrigatório',
            'max_length' => 'Máximo 69 caractéres',
            'is_unique' => 'Já existe',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['escapeData'];
    protected $beforeUpdate   = ['escapeData'];
}
