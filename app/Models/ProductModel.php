<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'master_barang';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_barang', 'foto_barang', 'jenis_barang', 'kuantitas', 'harga_per_satuan'];

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
    public function getAllProducts($keyword = null)
    {
        if ($keyword) {
            return $this->select('master_barang.id as id, nama_barang, foto_barang, kuantitas, harga_per_satuan, jenis_barang.kategori as jenis_barang')->join('jenis_barang', 'master_barang.jenis_barang=jenis_barang.id')
                ->like('nama_barang', '%' . $keyword . '%')
                ->orLike('kategori', '%' . $keyword . '%')
                ->orderBy('id', 'desc')->paginate($this->numberOfPagination, "products");
        }

        return $this->select('master_barang.id as id, nama_barang, foto_barang, kuantitas, harga_per_satuan, jenis_barang.kategori as jenis_barang')->join('jenis_barang', 'master_barang.jenis_barang=jenis_barang.id')->orderBy('id', 'desc')->paginate($this->numberOfPagination, "products");
    }
}
