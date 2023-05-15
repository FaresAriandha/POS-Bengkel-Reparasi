<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\EmployeeModel;
use App\Models\ProductModel;
use App\Models\UserModel;

class EmployeeController extends BaseController
{
    protected $data;
    protected $model, $session, $user;

    public function __construct()
    {
        $this->model = new EmployeeModel();
        $this->user = new UserModel();
        $this->data['session'] = \Config\Services::session();
        $this->data['pagination'] = $this->model->numberOfPagination;
    }

    public function index()
    {
        $this->data['page_title'] = "List Employees";
        $this->data['menu'] = "employees";
        $this->data['employees'] = $this->model->getAllEmployees();
        $this->data['pager'] = $this->model->pager;

        $keyword = $this->request->getVar('keyword');
        if ($keyword != '') {
            $this->data['employees'] = $this->model->getAllEmployees($keyword);
        }
        return view('employees/list', $this->data);
    }

    public function add()
    {
        $this->data['page_title'] = "Add Employee";
        $this->data['menu'] = "add_employee";
        return view('employees/add', $this->data);
    }

    public function store()
    {
        $dataInput = $this->request->getVar();
        $time = Time::now('America/Chicago', 'en_US');

        $filterData = [
            "nama_karyawan" => esc($dataInput['nama_karyawan']),
            "jenis_kelamin" => esc($dataInput["jenis_kelamin"]),
            "alamat" => esc($dataInput['alamat']),
            "no_tlp" => esc($dataInput['no_tlp']),
            "role" => esc($dataInput['role']),
            "email" => esc($dataInput['email']),
        ];

        $rulesSet = [
            "nama_karyawan" => [
                "rules" => "required|is_unique[master_karyawan.nama_karyawan]",
                "errors" => [
                    "required" => "Harap isi nama karyawan terlebih dahulu",
                    "is_unique" => "Nama karyawan sudah terdaftar",
                ]
            ],
            "jenis_kelamin" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Harap isi jenis kelamin karyawan terlebih dahulu"
                ]
            ],
            "alamat" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Harap isi {field} terlebih dahulu"
                ]
            ],
            "no_tlp" => [
                "rules" => "required|max_length[20]",
                "errors" => [
                    "required" => "Harap isi nomor telepon terlebih dahulu",
                    "max_length" => "Digit nomor telepon maks. 20",
                ]
            ],
            "foto_karyawan" => [
                "rules" => "uploaded[foto_karyawan]|max_size[foto_karyawan,2048]|mime_in[foto_karyawan,image/png,image/jpg,image/jpeg]",
                "errors" => [
                    "uploaded" => "Harap cantumkan foto karyawan terlebih dahulu",
                    "max_size" => "Ukuran maks. foto karyawan 2 MB",
                    "mime_in" => "Format foto karyawan hanya dalam bentuk png, jpg, dan jpeg",
                ]
            ],
            "role" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Harap isi {field} terlebih dahulu"
                ]
            ],
            "email" => [
                "rules" => "required|valid_email|max_length[50]",
                "errors" => [
                    "required" => "Harap isi {field} terlebih dahulu",
                    "valid_email" => "format {field} salah",
                    "max_length" => "{field} maksimal karakter 50",
                ]
            ],
        ];

        // dd($this->validate($rulesSet));
        if (!$this->validate($rulesSet)) {
            return redirect()->to(base_url('/employees/add'))->withInput();
        }

        $dataAkun = [
            "username" => "EMP" . $time->timestamp,
            "email" => esc($filterData['email']),
            "password" => "EMP" . $time->timestamp,
            "role" => esc($dataInput['role']),
        ];

        $this->createAcc($dataAkun);

        $idPengguna = $this->user->select('id')->where('username', $dataAkun['username'])->first()['id'];

        $foto = $this->request->getFile('foto_karyawan');
        $namaFile = $filterData['nama_karyawan'] . "_" . $time->timestamp . "." . $foto->getExtension();
        $foto->move('img/uploads/employees/', $namaFile);
        $filterData['foto_karyawan'] = $namaFile;

        $filterData['id_akun'] = $idPengguna;

        // Insert ke db
        $this->model->insert($filterData);
        session()->setFlashdata('add', 'Berhasil tambah data');
        return redirect()->to(base_url('/employees'));
    }

    public function edit($id)
    {

        $this->data['page_title'] = "Edit Product";
        $this->data['menu'] = "employees";
        $this->data['employee'] = $this->model->getEmployeeById($id);
        return view('employees/edit', $this->data);
    }

    public function update()
    {
        $dataInput = $this->request->getVar();
        $existData = $this->model->where('id', $dataInput['id_karyawan'])->first();

        $time = Time::now('America/Chicago', 'en_US');

        $filterData = [
            "nama_karyawan" => esc($dataInput['nama_karyawan']),
            "jenis_kelamin" => esc($dataInput["jenis_kelamin"]),
            "alamat" => esc($dataInput['alamat']),
            "no_tlp" => esc($dataInput['no_tlp']),
            "role" => esc($dataInput['role']),
            "email" => esc($dataInput['email']),
        ];


        $rulesSet = [
            "nama_karyawan" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Harap isi nama karyawan terlebih dahulu",
                ]
            ],
            "jenis_kelamin" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Harap isi jenis kelamin karyawan terlebih dahulu"
                ]
            ],
            "alamat" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Harap isi {field} terlebih dahulu"
                ]
            ],
            "no_tlp" => [
                "rules" => "required|max_length[20]",
                "errors" => [
                    "required" => "Harap isi nomor telepon terlebih dahulu",
                    "max_length" => "Digit nomor telepon maks. 20",
                ]
            ],
            "foto_karyawan" => [
                "rules" => "max_size[foto_karyawan,2048]|mime_in[foto_karyawan,image/png,image/jpg,image/jpeg]",
                "errors" => [
                    "max_size" => "Ukuran maks. foto karyawan 2 MB",
                    "mime_in" => "Format foto karyawan hanya dalam bentuk png, jpg, dan jpeg",
                ]
            ],
            "role" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Harap isi {field} terlebih dahulu"
                ]
            ],
            "email" => [
                "rules" => "required|valid_email|max_length[50]",
                "errors" => [
                    "required" => "Harap isi {field} terlebih dahulu",
                    "valid_email" => "format {field} salah",
                    "max_length" => "{field} maksimal karakter 50",
                ]
            ],
        ];

        if ($filterData['nama_karyawan'] != $existData['nama_karyawan']) {
            $rulesSet['nama_karyawan']['rules'] = 'required|is_unique[master_karyawan.nama_karyawan]';
            $rulesSet['nama_karyawan']['errors'] = [
                "required" => "Harap isi nama karyawan terlebih dahulu",
                "is_unique" => "Nama karyawan sudah terdaftar",
            ];
        }

        // Validasi
        if (!$this->validate($rulesSet)) {
            return redirect()->to(base_url('/employees/edit/' . $dataInput['id_karyawan']))->withInput();
        }

        // Upload Foto Terbaru
        $foto = $this->request->getFile('foto_karyawan');
        if ($foto->getError() != 4) {
            // Hapus foto yang sudah ada
            unlink("img/uploads/employees/" . $existData['foto_karyawan']);

            // Tambahkan foto yang baru
            $namaFile = $filterData['nama_karyawan'] . "_" . $time->timestamp . "." . $foto->getExtension();
            $foto->move('img/uploads/employees/', $namaFile);
            $filterData['foto_karyawan'] = $namaFile;
        }

        // Update Akun Pengguna
        $dataAkun = [
            "email" => esc($filterData['email']),
            "role" => esc($filterData['role']),
        ];
        // dd($existData);
        $this->updateAcc($dataAkun, $existData['id_akun']);

        // Insert ke db karyawan
        $this->model->update($dataInput['id_karyawan'], $filterData);
        session()->setFlashdata('update', 'Berhasil perbarui data');
        return redirect()->to(base_url('/employees'));
    }


    public function destroy($id)
    {
        $employee = $this->model->find($id);
        unlink("img/uploads/employees/" . $employee['foto_karyawan']);
        $this->user->delete($employee['id_akun']);
        session()->setFlashdata('delete', 'Berhasil hapus data');
        return redirect()->to(base_url('/employees'));
    }


    public function createAcc($dataAkun = [])
    {
        $filterData = [
            "username" => $dataAkun['username'],
            "email" => $dataAkun['email'],
            "password" => password_hash(esc($dataAkun['password']), PASSWORD_BCRYPT),
            "role" => $dataAkun['role'],
        ];

        // Insert ke db
        $this->user->insert($filterData);
    }


    public function updateAcc($dataAkun = [], $id)
    {
        // Insert ke db
        $this->user->update($id, $dataAkun);
    }
}
