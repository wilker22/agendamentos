<?php

namespace App\Models;

use App\Entities\Unit;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Model;

class UnitModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'units';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Unit::class;
    protected $useSoftDeletes   = false; // vamos excluir o registro
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'email',
        'phone',
        'coordinator',
        'address',
        'services',
        'starttime',
        'endtime',
        'servicetime',
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
        'phone'         => 'required|exact_length[14]|is_unique[units.phone,id,{id}]',
        'email'         => 'required|valid_email|max_length[99]|is_unique[units.email,id,{id}]',
        'coordinator'   => 'required|max_length[69]',
        'address'       => 'required|max_length[128]',
        'starttime'     => 'required',
        'endtime'       => 'required',
        'servicetime'   => 'required',
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
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];



    public function findOrFail(int|string $id): object
    {

        $row = $this->find($id);

        return $row ?? throw new PageNotFoundException("Registro {$id} não encontrado");
    }
}
