<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use App\orders\Productorder;
use App\orders\Employeeorder;
use App\Controllers\BaseController;
use App\Models\EmployeeModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\orders\Orderorder;
use CodeIgniter\Model;

class OrderController extends BaseController
{
    protected $data;
    protected $karyawan, $session, $product, $order, $trx;

    public function __construct()
    {
        $this->karyawan = new EmployeeModel();
        $this->product = new ProductModel();
        $this->order = new OrderModel();
        $this->trx = new TransactionModel();
        $this->data['session'] = \Config\Services::session();
        $this->data['pagination'] = $this->order->numberOfPagination;
    }

    public function index()
    {
        $this->data['page_title'] = "List Orders";
        $this->data['menu'] = "orders";
        $this->data['orders'] = $this->order->getAllOrders();
        $this->data['pager'] = $this->order->pager;

        $keyword = $this->request->getVar('keyword');
        if ($keyword != '') {
            $this->data['orders'] = $this->order->getAllOrders($keyword);
        }
        return view('orders/list', $this->data);
    }

    public function add()
    {
        $this->data['page_title'] = "Add Order";
        $this->data['menu'] = "add_order";
        $this->data['products'] = $this->product->findAll();
        return view('orders/add', $this->data);
    }

    public function store()
    {
        $dataInput = $this->request->getVar();
        $time = Time::now('America/Chicago', 'en_US');

        $nama_barang = explode(',', $dataInput['data_nama_barang']);
        $subtotal = explode(',', $dataInput['data_subtotal']);
        $jumlah = explode(',', $dataInput['data_jumlah']);

        // Set Tanggal Pemesanan
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s', time());

        $filterData = [
            "nama_pembeli" => esc($dataInput['nama_pembeli']),
            "no_tlp" => esc($dataInput["no_tlp"]),
            "id_pesanan" => 'OID' . $time->timestamp,
            "id_karyawan" => $this->karyawan->select('id')->where('id_akun', session()->get('logged_in')['id'])->first()['id'],
            "tgl_pemesanan" => $date
        ];


        for ($i = 0; $i < count($subtotal); $i++) {
            $data_produk = $this->product->select('*')->where('nama_barang', $nama_barang[$i])->first();
            $filterData['id_barang'] = $data_produk['id'];
            $filterData['total_harga_per_barang'] = (int)$subtotal[$i];
            $filterData['jumlah'] = (int)$jumlah[$i];

            $qty = $data_produk['kuantitas'];

            $this->order->insert($filterData);
            $updateQty = $qty - $filterData['jumlah'];

            $this->product->update($filterData['id_barang'], ['kuantitas' => $updateQty]);
        }

        $this->trx->insert(['id_pesanan' => $filterData['id_pesanan']]);
        session()->setFlashdata('add', 'Berhasil tambah data');
        return redirect()->to(base_url('/orders'));
    }


    public function destroy($id)
    {
        $order = $this->order->where('id_pesanan', $id)->findAll();

        for ($i = 0; $i < count($order); $i++) {
            $currentQty = $this->product->select('kuantitas')->where('id', $order[$i]['id_barang'])->first()['kuantitas'];
            $qty = $order[$i]['jumlah'];
            $updateQty = $currentQty + $qty;
            $this->product->update($order[$i]['id_barang'], ['kuantitas' => $updateQty]);
        }

        $this->trx->where('id_pesanan', $id)->set('status', 'dibatalkan')->update();
        $this->order->where('id_pesanan', $id)->delete();
        session()->setFlashdata('delete', 'Berhasil hapus data');
        return redirect()->to(base_url('/orders'));
    }


    public function show()
    {
        $id = $this->request->getVar('id');
        $data['status'] = 200;
        $data['data']['orders'] = $this->order->getDetailPesanan($id);
        $data['data']['price'] = $this->order->getTotalHargaBelanja($id);

        return json_encode($data);
    }

    public function detailProduct()
    {
        $id = $this->request->getVar('id');
        $data['status'] = 200;
        $data['product'] = $this->product->getDetailProduct($id);

        return json_encode($data);
    }
}
