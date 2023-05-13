<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class ProductController extends BaseController
{
    protected $data;
    protected $model, $session;

    public function __construct()
    {
        $this->model = new ProductModel();
        $this->data['session'] = \Config\Services::session();
        $this->data['page_title'] = "Products";
    }

    public function index()
    {
        $this->data['menu'] = "products";
        return view('products/list', $this->data);
    }

    public function add()
    {
        $this->data['menu'] = "add_product";
        return view('products/add', $this->data);
    }
}
