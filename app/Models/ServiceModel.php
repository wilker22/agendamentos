<?php

namespace App\Models;

use App\Entities\Service;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Model;

class ServiceModel extends MyBaseModel
{
    protected $DBGroup          = 'default';
    protected $table            = 'services';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Service::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'active',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'name' => 'required|max_length[100]|is_unique[services.name,id, {id}]',
    ];

    protected $validationMessages   = [
        'name' => [
            'required' => 'Obrigatório!',
            'max_length' => 'Máximo de 99 caracteres',
            'unique' => 'Já existe registro com esses dados!'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['escapeData'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['escapeData'];
}
