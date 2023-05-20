<?= $this->extend('dashboard/templates/main'); ?>

<?= $this->section('content'); ?>
<div class="row mt-3 mb-5 px-3">
  <h1 class="my-3">Form Edit Produk</h1>
  <div class="col-lg-8 border border-2 rounded-3 p-3 shadow">
    <?php $error = session()->get('_ci_validation_errors'); ?>
    <form action="/products/update" method="post" enctype="multipart/form-data" class="d-flex flex-column">
      <input type="hidden" name="id_product" value="<?= $product['id']; ?>">
      <div class="mb-3">
        <label for="nama_barang" class="form-label">Nama Barang</label>
        <textarea class="form-control <?= isset($error['nama_barang']) ? 'is-invalid' : ''; ?>" id="exampleFormControlTextarea1" rows="2" placeholder="FDR Ring 14, 2023" name="nama_barang"><?= $product['nama_barang']; ?></textarea>
        <div class="invalid-feedback">
          <?= isset($error['nama_barang']) ? $error['nama_barang'] : ''; ?>
        </div>
      </div>
      <div class="mb-3">
        <label for="jenis_barang" class="form-label">Jenis Barang</label>
        <select class="form-select  <?= isset($error['jenis_barang']) ? 'is-invalid' : ''; ?>" name="jenis_barang">
          <option disabled value="">-- Pilih salah satu --</option>
          <?php foreach ($categories as $category) : ?>
            <?php if ($product['jenis_barang'] == $category['id']) : ?>
              <option value="<?= $category['id']; ?>" selected><?= $category['kategori']; ?></option>
            <?php endif; ?>
          <?php endforeach; ?>
          <div class="invalid-feedback">
            <?= isset($error['jenis_barang']) ? $error['jenis_barang'] : ''; ?>
          </div>
        </select>
      </div>
      <div class="mb-3 col-lg-2 col-4">
        <label for="kuantitas" class="form-label">Kuantitas</label>
        <div class="input-group">
          <input type="number" class="form-control  <?= isset($error['kuantitas']) ? 'is-invalid' : ''; ?>" id="kuantitas" name="kuantitas" placeholder="0" value="<?= $product['kuantitas']; ?>">
          <span class="input-group-text" id="basic-addon1">Qty</span>
          <div class="invalid-feedback">
            <?= isset($error['kuantitas']) ? $error['kuantitas'] : ''; ?>
          </div>
        </div>
      </div>
      <div class="mb-3">
        <label for="harga_per_satuan" class="form-label">Harga Per Satuan</label>
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Rp.</span>
          <input type="number" class="form-control  <?= isset($error['harga_per_satuan']) ? 'is-invalid' : ''; ?>" id="harga_per_satuan" name="harga_per_satuan" placeholder="0" value="<?= $product['harga_per_satuan']; ?>">
          <div class="invalid-feedback">
            <?= isset($error['harga_per_satuan']) ? $error['harga_per_satuan'] : ''; ?>
          </div>
        </div>
      </div>
      <div class="mb-3">
        <label for="foto_barang" class="form-label">Foto Barang</label>
        <img src="/img/uploads/products/<?= $product['foto_barang']; ?>" alt="" class="img-preview d-block my-3" width="100">
        <input type="file" class="form-control  <?= isset($error['foto_barang']) ? 'is-invalid' : ''; ?>" name="foto_barang" id="foto_barang">
        <div class="invalid-feedback">
          <?= isset($error['foto_barang']) ? $error['foto_barang'] : ''; ?>
        </div>
      </div>
      <div class="button align-self-end">
        <a href="/products" class="btn btn-danger">Kembali</a>
        <button type="submit" class="btn btn-primary">Ubah</button>
      </div>
    </form>
  </div>
</div>

<script>
  // Image Preview
  const img_preview = document.querySelector(".img-preview");
  const input_img = document.getElementById("foto_barang");
  input_img.addEventListener("change", function(e) {
    img_preview.src = URL.createObjectURL(this.files[0]);
    img_preview.classList.remove("d-none");
  });
</script>
<?= $this->endSection(); ?>