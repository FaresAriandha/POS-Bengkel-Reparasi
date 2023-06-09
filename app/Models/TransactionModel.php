<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_pesanan', 'status'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
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

    protected $numberOfPagination = 5;
    public function getAlltransactions($keyword = null)
    {
        if ($keyword) {
            return $this->select('*')
                ->whereNotIn('status', ['dibatalkan'])
                ->like('id_pesanan', '%' . $keyword . '%')
                ->orLike('status', '%' . $keyword . '%')
                ->orderBy('id_pesanan', 'desc')->paginate($this->numberOfPagination, "transactions");
        }

        return $this->select('*')->whereNotIn('status', ['dibatalkan'])->orderBy('id_pesanan', 'desc')->paginate($this->numberOfPagination, "transactions");
    }
}
