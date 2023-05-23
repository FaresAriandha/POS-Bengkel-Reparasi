<?php

namespace App\Controllers;

use App\Models\UserModel;
// use \Config\Services;
use App\Controllers\BaseController;
use App\Models\EmployeeModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\TransactionModel;
use Config\Services;

class UserController extends BaseController
{
    protected $data;
    protected $model, $session, $employees, $products, $orders, $trx;

    public function __construct()
    {
        $this->model = new UserModel();
        $this->employees = new EmployeeModel();
        $this->products = new ProductModel();
        $this->orders = new OrderModel();
        $this->trx = new TransactionModel();
        $this->data['session'] = \Config\Services::session();
    }
    public function index()
    {
        //
        $this->data = [
            "page_title" => "overview",
            "menu" => "dashboard",
            "user" => $this->employees->where('id_akun', session()->get('logged_in')['id'])->first(),
            "count_employees" => count($this->employees->findAll()),
            "count_products" => count($this->products->findAll()),
            "count_orders" => count($this->orders->getAllOrders()),
            "count_trx" => count($this->trx->getAlltransactions()),
        ];
        return view('dashboard/index', $this->data);
    }

    public function login()
    {
        return view('login-register/login');
    }

    public function logout()
    {
        session()->removeTempdata('logged_in');
        session()->setFlashdata('logout', "berhasil logout, silahkan login kembali");
        return redirect()->to(base_url('/login'));
    }

    public function register()
    {
        return view('login-register/register', $this->data);
    }

    public function store()
    {

        $dataInput = $this->request->getVar();

        $filterData = [
            "username" => esc($dataInput['username']),
            "email" => esc($dataInput['email']),
            "password" => password_hash(esc($dataInput['password']), PASSWORD_DEFAULT),
        ];

        $rulesSet = [
            "username" => [
                "rules" => "required|max_length[20]|is_unique[master_pengguna.username]",
                "errors" => [
                    "required" => "Harap isi {field} terlebih dahulu",
                    "max_length" => "{field} maksimal karakter 20",
                    "is_unique" => "{field} sudah terdaftar",
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
            "password" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Harap isi {field} terlebih dahulu"
                ]
            ],
        ];

        // dd($this->validate($rulesSet));
        if (!$this->validate($rulesSet)) {
            return redirect()->to(base_url('/register'))->withInput();
        }

        // Insert ke db
        $this->model->insert($filterData);

        // return redirect()->to(base_url('/login'))->with('daftar_berhasil', 'Pendaftaran Akun Berhasil');
        return $this->authenticate();
    }

    public function authenticate()
    {
        $dataInput = $this->request->getVar();
        // dd($dataInput);
        $filterData = [
            "username" => esc($dataInput['username']),
            "password" => esc($dataInput['password']),
        ];

        $rulesSet = [
            "username" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Harap isi {field} terlebih dahulu",
                ]
            ],
            "password" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Harap isi {field} terlebih dahulu"
                ]
            ],
        ];

        if (!$this->validate($rulesSet)) {
            return redirect()->to(base_url('/login'))->withInput();
        }

        // Cari akun pengguna
        $login_account = $this->model->getAccountByUsername($filterData['username']);

        // Cek passwordnya
        if ($login_account) {
            $password = $login_account['password'];
            if (password_verify($filterData['password'], $password)) {
                session()->set('logged_in', $login_account);
                return redirect()->to(base_url('/dashboard'));
            }
        }

        // Kalo ga ditemukan
        return redirect()->to(base_url('/login'))->with('not_found', 'Username atau password salah');
    }

    public function show()
    {
        $data = $this->request->getVar();
        // $username = $this->request->getVar('username');
        // dd('he');
        $passwordExist = $this->model->where('username', $data->username)->first()['password'];
        $response['status'] = 200;
        $response['message'] = "Password cocok!";
        if (!password_verify($data->password, $passwordExist)) {
            $response['status'] = "404";
            $response['message'] = "Password tidak cocok!";
            return json_encode($response);
        }
        return json_encode($response);
    }

    public function edit($username)
    {
        // $username = $this->request->getVar('username');
        // dd('he');
        $this->data['page_title'] = "Edit Akun";
        $this->data['menu'] = "users";
        $this->data['user'] = $this->model->where('username', $username)->first();

        return view('users/edit', $this->data);
    }

    public function update()
    {


        $filterData = [
            'username' => esc($this->request->getVar('username')),
            'email' => esc($this->request->getVar('email')),
            'password' => esc($this->request->getVar('password')),
            'old-password' => esc($this->request->getVar('old-password')),
        ];
        $username = session()->get('logged_in')['username'];
        $userExist = $this->model->where('username', $username)->first();

        // dd($this->request->getVar());

        $rulesSet = [
            "username" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Harap isi {field} terlebih dahulu",
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
            "password" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Harap isi {field} terlebih dahulu"
                ]
            ],
        ];

        if ($filterData['email'] != $userExist['email']) {
            $rulesSet['email']['rules'] = 'required|valid_email|max_length[50]|is_unique[master_pengguna.email]';
            $rulesSet['email']['errors'] = [
                "required" => "Harap isi {field} terlebih dahulu",
                "valid_email" => "format {field} salah",
                "max_length" => "{field} maksimal karakter 50",
                "is_unique" => "{field} sudah terdaftar",
            ];
        }

        if ($filterData['username'] != $userExist['username']) {
            $rulesSet['username']['rules'] = 'required|max_length[20]|is_unique[master_pengguna.username]';
            $rulesSet['username']['errors'] = [
                "required" => "Harap isi {field} terlebih dahulu",
                "max_length" => "{field} maksimal karakter 20",
                "is_unique" => "{field} sudah terdaftar",
            ];
        }

        // Validasi
        if (!$this->validate($rulesSet)) {
            return redirect()->to(base_url("/users/" . session()->get('logged_in')['username']))->withInput();
        }

        $filterData['password'] = password_hash($filterData['password'], PASSWORD_DEFAULT);

        $this->model->where('username', $username)
            ->set('username', $filterData['username'])
            ->set('email', $filterData['email'])
            ->set('password', $filterData['password'])
            ->update();

        $newAccount = $this->model->where('username', $filterData['username'])->first();

        session()->remove('logged_in');
        session()->set('logged_in', $newAccount);
        return redirect()->to(base_url("/users/" . session()->get('logged_in')['username']))->with('update', 'Berhasil update akun');
    }
}
