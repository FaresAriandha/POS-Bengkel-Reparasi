<?= $this->extend('dashboard/templates/main'); ?>

<?= $this->section('content'); ?>
<div class="row mt-5">
  <h1>Daftar Barang</h1>
  <div class="add-search d-flex w-full justify-content-between mt-3 mb-3">
    <a href="/products/add" class="btn btn-primary">Tambah Produk</a>
    <form class="d-flex" role="search">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead class="bg-secondary text-white text-center align-middle">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nama Produk</th>
          <th scope="col">Foto Produk</th>
          <th scope="col">Kategori Produk</th>
          <th scope="col">Jumlah Tersedia</th>
          <th scope="col">Harga per satuan</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row" class="text-center">1</th>
          <td>Alfares Ariandha Nurdin</td>
          <td class="text-center">Kategori</td>
          <td class="text-center">aksjaksjaksjak</td>
          <td class="text-center">3</td>
          <td class="text-center">Rp. <?= number_format(110000); ?></td>
          <td class="w-full d-flex justify-content-center gap-3">
            <a href="" class="btn btn-danger"><i class="bi bi-trash"></i></a>
            <button class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-info-circle"></i></button>
            <a href="" class="btn btn-success"><i class="bi bi-pencil-square"></i></a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>