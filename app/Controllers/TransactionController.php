<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use App\Models\OrderModel;
use App\Models\TransactionModel;
use App\Controllers\BaseController;

class TransactionController extends BaseController
{
    protected $data;
    protected $model, $session, $order;

    public function __construct()
    {
        $this->model = new TransactionModel();
        $this->order = new OrderModel();
        $this->data['session'] = \Config\Services::session();
        $this->data['pagination'] = $this->model->numberOfPagination;
    }

    public function index()
    {
        $this->data['page_title'] = "List transactions";
        $this->data['menu'] = "transactions";
        $this->data['transactions'] = $this->model->getAlltransactions();
        $this->data['pager'] = $this->model->pager;

        $keyword = $this->request->getVar('keyword');
        if ($keyword != '') {
            $this->data['transactions'] = $this->model->getAlltransactions($keyword);
        }
        return view('transactions/list', $this->data);
    }

    public function update($id_pesanan)
    {
        // dd($id_pesanan);
        $this->model->where('id_pesanan', $id_pesanan)->set('status', 'sukses')->update();
        session()->setFlashdata('update', "/transactions/print/$id_pesanan");
        return redirect()->to(base_url('/orders'));
    }

    public function print($id)
    {
        // ob_start();
        // $product = $this->model->find($id);
        // unlink("img/uploads/products/" . $product['foto_barang']);
        // $this->model->delete($id);
        // dd($id);
        $data_pesanan['data'] = $this->order->getDetailPesanan($id);
        return view('/transactions/print', $data_pesanan);
        // $content = ob_get_clean();
        // $dompdf = new \Dompdf\Dompdf();
        // $dompdf->loadHtml(view('/transactions/print', $data_pesanan));
        // $dompdf->setPaper('A4', 'landscape');
        // $dompdf->render();
        // $dompdf->stream();
        // dd($data_pesanan);
        // session()->setFlashdata('delete', 'Berhasil hapus data');
    }
}
