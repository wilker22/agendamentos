<?php

namespace App\Models;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Model;

class MyBaseModel extends Model
{

    protected function escapeData(array $data)
    {
        if (!isset($data['data'])) {

            return $data;
        }

        return esc($data);
    }

    public function findOrFail(int|string $id): object
    {
        $row = $this->find($id);
        return $row ?? throw new PageNotFoundException("Registro {$id} não encontrado.");
    }
}
