<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pemesanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_pesanan', 'id_barang', 'id_karyawan', 'tgl_pemesanan', 'jumlah', 'total_harga_per_barang', 'nama_pembeli', 'no_tlp'];

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


    public function getAllOrders($keyword = null)
    {
        if ($keyword) {
            return $this->select('id_pesanan, tgl_pemesanan, count(id_pesanan) as total_barang, sum(total_harga_per_barang) as total_harga, nama_pembeli')->join('master_karyawan', 'pemesanan.id_karyawan=master_karyawan.id')->join('master_barang', 'pemesanan.id_barang=master_barang.id')
                ->like('id_pesanan', '%' . $keyword . '%')
                ->orLike('nama_pembeli', '%' . $keyword . '%')
                ->groupBy('id_pesanan, tgl_pemesanan, nama_pembeli')->orderBy('tgl_pemesanan', 'desc')->paginate($this->numberOfPagination, "orders");
        }

        return $this->select('id_pesanan, tgl_pemesanan, count(id_pesanan) as total_barang, sum(total_harga_per_barang) as total_harga, nama_pembeli')->join('master_karyawan', 'pemesanan.id_karyawan=master_karyawan.id')->join('master_barang', 'pemesanan.id_barang=master_barang.id')->groupBy('id_pesanan, tgl_pemesanan, nama_pembeli')->orderBy('tgl_pemesanan', 'desc')->paginate($this->numberOfPagination, "orders");
    }

    public function getDetailPesanan($id)
    {
        return $this->select('id_pesanan, tgl_pemesanan, jumlah, total_harga_per_barang, nama_pembeli, pemesanan.no_tlp as no_tlp, master_barang.nama_barang as nama_barang, master_barang.harga_per_satuan as harga_barang, master_karyawan.nama_karyawan as nama_karyawan')->join('master_karyawan', 'pemesanan.id_karyawan=master_karyawan.id')->join('master_barang', 'pemesanan.id_barang=master_barang.id')->where('id_pesanan', $id)->findAll();
    }

    public function getTotalHargaBelanja($id)
    {
        return $this->select('sum(total_harga_per_barang) as total_belanja')->where('id_pesanan', $id)->groupBy('id_pesanan')->first();
    }
}
