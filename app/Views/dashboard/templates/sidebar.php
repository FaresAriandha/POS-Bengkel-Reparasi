<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3 sidebar-sticky">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link <?= $menu == "dashboard" ? 'active' : ''; ?>" aria-current="page" href="<?= base_url('/dashboard'); ?>">
          <span data-feather="home" class="align-text-bottom"></span>
          Dashboard
        </a>
      </li>
    </ul>

    <!-- Mahasiswa -->
    <ul class="nav flex-column">
      <h6 class="sidebar-heading text-muted d-flex flex-col justify-content-between align-items-center px-3 mt-4 fs-6 fw-bold">
        Manajemen Barang
      </h6>
      <li class="nav-item">
        <a class="nav-link <?= $menu == 'products' ? 'active' : ''; ?>" href="<?= base_url('/products'); ?>">
          <span data-feather="file-text" class="align-text-bottom"></span>
          Daftar Barang
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $menu == "add_product" ? 'active' : ''; ?>" href="<?= base_url('/products/add'); ?>">
          <span data-feather="file-text" class="align-text-bottom"></span>
          Tambah Barang
        </a>
      </li>
    </ul>


    <!-- Contacts -->
    <ul class="nav flex-column">
      <h6 class="sidebar-heading text-muted d-flex flex-col justify-content-between align-items-center px-3 mt-4 fs-6 fw-bold">
        Manajemen Karyawan
      </h6>
      <li class="nav-item">
        <a class="nav-link <?= $menu == "contacts" ? 'active' : ''; ?>" href="<?= base_url('/contacts'); ?>">
          <span data-feather="file-text" class="align-text-bottom"></span>
          Daftar Kontak
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $menu == "add_contact" ? 'active' : ''; ?>" href="<?= base_url('/contacts/create'); ?>">
          <span data-feather="file-text" class="align-text-bottom"></span>
          Tambah Kontak
        </a>
      </li>
    </ul>

    <!-- Contacts -->

    <ul class="nav flex-column">
      <h6 class="sidebar-heading text-muted d-flex flex-col justify-content-between align-items-center px-3 mt-4 fs-6 fw-bold">
        Manajemen Pemesanan
      </h6>
      <li class="nav-item">
        <a class="nav-link <?= $menu == "contacts" ? 'active' : ''; ?>" href="<?= base_url('/contacts'); ?>">
          <span data-feather="file-text" class="align-text-bottom"></span>
          Daftar Kontak
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $menu == "add_contact" ? 'active' : ''; ?>" href="<?= base_url('/contacts/create'); ?>">
          <span data-feather="file-text" class="align-text-bottom"></span>
          Tambah Kontak
        </a>
      </li>
    </ul>

    <!-- Contacts -->
    <ul class="nav flex-column">
      <h6 class="sidebar-heading text-muted d-flex flex-col justify-content-between align-items-center px-3 mt-4 fs-6 fw-bold">
        Manajemen Transaksi
      </h6>
      <li class="nav-item">
        <a class="nav-link <?= $menu == "contacts" ? 'active' : ''; ?>" href="<?= base_url('/contacts'); ?>">
          <span data-feather="file-text" class="align-text-bottom"></span>
          Daftar Kontak
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $menu == "add_contact" ? 'active' : ''; ?>" href="<?= base_url('/contacts/create'); ?>">
          <span data-feather="file-text" class="align-text-bottom"></span>
          Tambah Kontak
        </a>
      </li>
    </ul>
  </div>
</nav>