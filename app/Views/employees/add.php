<?= $this->extend('dashboard/templates/main'); ?>

<?= $this->section('content'); ?>
<div class="row ms-2 mt-3 mb-5">
  <h1 class="my-3">Form Tambah Karyawan</h1>
  <div class="col-lg-8 border border-2 rounded-3 p-3 shadow">
    <?php $error = session()->get('_ci_validation_errors'); ?>
    <form action="/employees/store" method="post" enctype="multipart/form-data" class="d-flex flex-column">
      <div class="mb-3">
        <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
        <input type="text" class="form-control  <?= isset($error['nama_karyawan']) ? 'is-invalid' : ''; ?>" id="nama_karyawan" name="nama_karyawan" placeholder="Ucup Surucup" value="<?= old('nama_karyawan'); ?>">
        <div class="invalid-feedback">
          <?= isset($error['nama_karyawan']) ? $error['nama_karyawan'] : ''; ?>
        </div>
      </div>
      <div class="mb-3">
        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
        <select class="form-select  <?= isset($error['jenis_kelamin']) ? 'is-invalid' : ''; ?>" name="jenis_kelamin">
          <option selected value="">-- Pilih salah satu --</option>
          <option value="Laki-laki">Laki-laki</option>
          <option value="Perempuan">Perempuan</option>
        </select>
        <div class="invalid-feedback">
          <?= isset($error['jenis_kelamin']) ? $error['jenis_kelamin'] : ''; ?>
        </div>
      </div>
      <div class="mb-3">
        <label for="alamat" class="form-label">Alamat Domisili</label>
        <textarea class="form-control <?= isset($error['alamat']) ? 'is-invalid' : ''; ?>" id="alamat" rows="2" placeholder="Jl. Sukamaju No. 14, Cikokol, Tangerang" name="alamat"><?= old('alamat'); ?></textarea>
        <div class="invalid-feedback">
          <?= isset($error['alamat']) ? $error['alamat'] : ''; ?>
        </div>
      </div>
      <div class="mb-3">
        <label for="no_tlp" class="form-label">Nomor Telepon</label>
        <input type="number" class="form-control  <?= isset($error['no_tlp']) ? 'is-invalid' : ''; ?>" id="no_tlp" name="no_tlp" placeholder="0812345678910" value="<?= old('no_tlp'); ?>">
        <div class="invalid-feedback">
          <?= isset($error['no_tlp']) ? $error['no_tlp'] : ''; ?>
        </div>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" class="form-control  <?= isset($error['email']) ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="ucup@gmail.com" value="<?= old('email'); ?>">
        <div class="invalid-feedback">
          <?= isset($error['email']) ? $error['email'] : ''; ?>
        </div>
      </div>
      <div class="mb-3">
        <label for="role" class="form-label">Peran</label>
        <select class="form-select  <?= isset($error['role']) ? 'is-invalid' : ''; ?>" name="role">
          <option selected value="">-- Pilih salah satu --</option>
          <option value="admin">Admin</option>
          <option value="kasir">Kasir</option>
        </select>
        <div class="invalid-feedback">
          <?= isset($error['role']) ? $error['role'] : ''; ?>
        </div>
      </div>
      <div class="mb-3">
        <label for="foto_karyawan" class="form-label">Foto Karyawan</label>
        <img src="<?= old('foto_karyawan'); ?>" alt="" class="img-preview d-block my-3 d-none" width="100">
        <input type="file" class="form-control  <?= isset($error['foto_karyawan']) ? 'is-invalid' : ''; ?>" name="foto_karyawan" id="foto_karyawan">
        <div class="invalid-feedback">
          <?= isset($error['foto_karyawan']) ? $error['foto_karyawan'] : ''; ?>
        </div>
      </div>
      <div class="button align-self-end">
        <a href="/employees" class="btn btn-secondary ">Kembali</a>
        <button type="submit" class="btn btn-success">Tambah</button>
      </div>
    </form>
  </div>
</div>

<script>
  // Image Preview
  const img_preview = document.querySelector(".img-preview");
  const input_img = document.getElementById("foto_karyawan");
  input_img.addEventListener("change", function(e) {
    img_preview.src = URL.createObjectURL(this.files[0]);
    img_preview.classList.remove("d-none");
  });
</script>
<?= $this->endSection(); ?>