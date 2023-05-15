<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use App\Models\ProductModel;
use App\Controllers\BaseController;
use App\Models\CategoryModel;

class ProductController extends BaseController
{
    protected $data;
    protected $model, $session, $jenis;

    public function __construct()
    {
        $this->model = new ProductModel();
        $this->jenis = new CategoryModel();
        $this->data['session'] = \Config\Services::session();
        $this->data['pagination'] = $this->model->numberOfPagination;
    }

    public function index()
    {
        $this->data['page_title'] = "List Products";
        $this->data['menu'] = "products";
        $this->data['products'] = $this->model->getAllProducts();
        $this->data['pager'] = $this->model->pager;

        $keyword = $this->request->getVar('keyword');
        if ($keyword != '') {
            $this->data['products'] = $this->model->getAllProducts($keyword);
        }
        return view('products/list', $this->data);
    }

    public function add()
    {
        $this->data['page_title'] = "Add Product";
        $this->data['menu'] = "add_product";
        $this->data['categories'] = $this->jenis->findAll();
        return view('products/add', $this->data);
    }

    public function store()
    {
        $dataInput = $this->request->getVar();
        // dd($dataInput);
        $filterData = [
            "nama_barang" => esc($dataInput['nama_barang']),
            "jenis_barang" => esc($dataInput["jenis_barang"]),
            "kuantitas" => esc($dataInput['kuantitas']),
            "harga_per_satuan" => esc($dataInput['harga_per_satuan']),
        ];

        $rulesSet = [
            "nama_barang" => [
                "rules" => "required|is_unique[master_barang.nama_barang]",
                "errors" => [
                    "required" => "Harap isi nama produk terlebih dahulu",
                    "is_unique" => "Nama produk sudah terdaftar",
                ]
            ],
            "jenis_barang" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Harap isi jenis barang terlebih dahulu"
                ]
            ],
            "kuantitas" => [
                "rules" => "required|max_length[5]",
                "errors" => [
                    "required" => "Harap isi {field} terlebih dahulu",
                    "max_length" => "Digit untuk harga satuan maks. 5",
                ]
            ],
            "harga_per_satuan" => [
                "rules" => "required|max_length[11]",
                "errors" => [
                    "required" => "Harap isi harga satuan terlebih dahulu",
                    "max_length" => "Digit untuk harga satuan maks. 11",
                ]
            ],
            "foto_barang" => [
                "rules" => "uploaded[foto_barang]|max_size[foto_barang,2048]|mime_in[foto_barang,image/png,image/jpg,image/jpeg]",
                "errors" => [
                    "uploaded" => "Harap cantumkan foto barang terlebih dahulu",
                    "max_size" => "Ukuran maks. foto barang 2 MB",
                    "mime_in" => "Format foto barang hanya dalam bentuk png, jpg, dan jpeg",
                ]
            ],
        ];

        // dd($this->validate($rulesSet));
        if (!$this->validate($rulesSet)) {
            return redirect()->to(base_url('/products/add'))->withInput();
        }

        $time = Time::now('America/Chicago', 'en_US');
        $foto = $this->request->getFile('foto_barang');
        $namaFile = $filterData['nama_barang'] . "_" . $time->timestamp . "." . $foto->getExtension();
        $foto->move('img/uploads/products/', $namaFile);
        $filterData['foto_barang'] = $namaFile;

        // Insert ke db
        $this->model->insert($filterData);
        session()->setFlashdata('add', 'Berhasil tambah data');
        return redirect()->to(base_url('/products'));
    }

    public function edit($id)
    {

        $this->data['page_title'] = "Edit Product";
        $this->data['menu'] = "products";
        $this->data['product'] = $this->model->where('id', $id)->first();
        $this->data['categories'] = $this->jenis->findAll();
        return view('products/edit', $this->data);
    }

    public function update()
    {
        $dataInput = $this->request->getVar();
        $existData = $this->model->where('id', $dataInput['id_product'])->first();
        $filterData = [
            "nama_barang" => esc($dataInput['nama_barang']),
            "jenis_barang" => esc($dataInput["jenis_barang"]),
            "kuantitas" => esc($dataInput['kuantitas']),
            "harga_per_satuan" => esc($dataInput['harga_per_satuan']),
        ];


        $rulesSet = [
            "nama_barang" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Harap isi nama produk terlebih dahulu",
                ]
            ],
            "jenis_barang" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Harap isi jenis barang terlebih dahulu"
                ]
            ],
            "kuantitas" => [
                "rules" => "required|max_length[5]",
                "errors" => [
                    "required" => "Harap isi {field} terlebih dahulu",
                    "max_length" => "Digit untuk harga satuan maks. 5",
                ]
            ],
            "harga_per_satuan" => [
                "rules" => "required|max_length[11]",
                "errors" => [
                    "required" => "Harap isi harga satuan terlebih dahulu",
                    "max_length" => "Digit untuk harga satuan maks. 11",
                ]
            ],
            "foto_barang" => [
                "rules" => "max_size[foto_barang,2048]|mime_in[foto_barang,image/png,image/jpg,image/jpeg]",
                "errors" => [
                    "max_size" => "Ukuran maks. foto barang 2 MB",
                    "mime_in" => "Format foto barang hanya dalam bentuk png, jpg, dan jpeg",
                ]
            ],
        ];

        if ($filterData['nama_barang'] != $existData['nama_barang']) {
            $rulesSet['nama_barang']['rules'] = 'required|is_unique[master_barang.nama_barang]';
            $rulesSet['nama_barang']['errors'] = [
                "required" => "Harap isi nama produk terlebih dahulu",
                "is_unique" => "Nama produk sudah terdaftar",
            ];
        }


        if (!$this->validate($rulesSet)) {
            return redirect()->to(base_url('/products/edit/' . $dataInput['id_product']))->withInput();
        }

        $foto = $this->request->getFile('foto_barang');

        if ($foto->getError() != 4) {
            // Hapus foto yang sudah ada
            unlink("img/uploads/products/" . $existData['foto_barang']);

            // Tambahkan foto yang baru
            $time = Time::now('America/Chicago', 'en_US');
            $namaFile = $filterData['nama_barang'] . "_" . $time->timestamp . "." . $foto->getExtension();
            $foto->move('img/uploads', $namaFile);
            $filterData['foto_barang'] = $namaFile;
        }

        // Insert ke db
        $this->model->update($dataInput['id_product'], $filterData);
        session()->setFlashdata('update', 'Berhasil perbarui data');
        return redirect()->to(base_url('/products'));
    }


    public function destroy($id)
    {
        $product = $this->model->find($id);
        unlink("img/uploads/products/" . $product['foto_barang']);
        $this->model->delete($id);
        session()->setFlashdata('delete', 'Berhasil hapus data');
        return redirect()->to(base_url('/products'));
    }
}
