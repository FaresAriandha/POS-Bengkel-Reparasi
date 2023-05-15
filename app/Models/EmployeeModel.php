<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'master_karyawan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_karyawan', 'jenis_kelamin', 'foto_karyawan', 'no_tlp', 'alamat', 'id_akun'];

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
    public function getAllEmployees($keyword = null)
    {
        if ($keyword) {
            return $this->select('master_karyawan.id as id, nama_karyawan, foto_karyawan, jenis_kelamin, alamat, no_tlp, master_pengguna.email as email, master_pengguna.role as role, master_pengguna.username as username, master_pengguna.password as password')->join('master_pengguna', 'master_karyawan.id_akun=master_pengguna.id')
                ->like('nama_karyawan', '%' . $keyword . '%')
                ->orLike('jenis_kelamin', '%' . $keyword . '%')
                ->orLike('role', '%' . $keyword . '%')
                ->orderBy('id', 'desc')->paginate($this->numberOfPagination, "employees");
        }

        return $this->select('master_karyawan.id as id, nama_karyawan, foto_karyawan, jenis_kelamin, alamat, no_tlp, master_pengguna.email as email, master_pengguna.role as role, master_pengguna.username as username, master_pengguna.password as password')->join('master_pengguna', 'master_karyawan.id_akun=master_pengguna.id')->orderBy('id', 'desc')->paginate($this->numberOfPagination, "employees");
    }

    public function getEmployeeById($id)
    {
        return $this->select('master_karyawan.id as id, nama_karyawan, foto_karyawan, jenis_kelamin, alamat, no_tlp, master_pengguna.email as email, master_pengguna.role as role')->join('master_pengguna', 'master_karyawan.id_akun=master_pengguna.id')->where('master_karyawan.id', $id)->first();
    }
}
