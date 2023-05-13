<?= $this->extend('dashboard/templates/main'); ?>

<?= $this->section('content'); ?>
<div class="row ms-2">
  <h1 class="my-3">Form Tambah Produk</h1>
  <div class="col-lg-8 border border-2 rounded-3 p-3 shadow">
    <form action="/products/store" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="nama_barang" class="form-label">Nama Barang</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" placeholder="FDR Ring 14, 2023" name="nama_barang"></textarea>
      </div>
      <div class="mb-3">
        <label for="jenis_barang" class="form-label">Jenis Barang</label>
        <select class="form-select" name="jenis_barang">
          <option selected disabled>-- Pilih salah satu --</option>
          <option value="1">Test</option>
        </select>
      </div>
      <div class="mb-3 col-2">
        <label for="kuantitas" class="form-label">Kuantitas</label>
        <div class="input-group">
          <input type="number" class="form-control" id="kuantitas" name="kuantitas" placeholder="0">
          <span class="input-group-text" id="basic-addon1">Qty</span>
        </div>
      </div>
      <div class="mb-3">
        <label for="harga_per_satuan" class="form-label">Harga Per Satuan</label>
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Rp.</span>
          <input type="number" class="form-control" id="harga_per_satuan" name="harga_per_satuan" placeholder="0">
        </div>
      </div>
      <div class="mb-3">
        <label for="foto_barang" class="form-label">Foto Barang</label>
        <img src="/img/google.png" alt="" class="img-preview d-block my-3" width="100">
        <input type="file" class="form-control" name="foto_barang" id="foto_barang">
      </div>
      <button type="submit" class="btn btn-primary">Tambah</button>
    </form>
  </div>
</div>
<?= $this->endSection(); ?>