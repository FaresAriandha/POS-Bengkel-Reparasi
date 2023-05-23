<?= $this->extend('dashboard/templates/main'); ?>

<?= $this->section('content'); ?>
<div class="row">
  <h1 class="my-4">Selamat datang, <?= $user['nama_karyawan']; ?> - <?= ucfirst(session()->get('logged_in')['role']); ?></h1>

  <!-- Grafik data -->
  <div class="col">
    <div class="row">
      <div class="col-md-3">
        <a href="<?= base_url('/products'); ?>" class="text-decoration-none">
          <div class="card mb-3 text-dark" style="max-width: 18rem; background: rgba(255, 128, 128, 0.5); border-radius: 16px; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.3);">
            <div class="card-header fs-5 bold">Produk Tersedia</div>
            <div class="card-body">
              <h5 class="card-title"><?= $count_products; ?></h5>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="<?= base_url('/employees'); ?>" class="text-decoration-none">
          <div class="card text-dark mb-3" style="max-width: 18rem; background: rgba(88, 154, 253, 0.5); border-radius: 16px; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.3);">
            <div class="card-header fs-5 bold">Karyawan</div>
            <div class="card-body">
              <h5 class="card-title"><?= $count_employees; ?></h5>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="<?= base_url('/orders'); ?>" class="text-decoration-none">
          <div class="card text-dark mb-3" style="max-width: 18rem; background: rgba(255, 213, 0, 0.3); border-radius: 16px; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.3);">
            <div class="card-header fs-5 bold">Pesanan</div>
            <div class="card-body">
              <h5 class="card-title"><?= $count_orders; ?></h5>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="<?= base_url('/transactions'); ?>" class="text-decoration-none">
          <div class="card text-dark mb-3" style="max-width: 18rem; background: rgba(73, 253, 73, 0.5); border-radius: 16px; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.3);">
            <div class="card-header fs-5 bold">Transaksi Berhasil</div>
            <div class="card-body">
              <h5 class="card-title"><?= $count_trx; ?></h5>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>

<script>
  $(function() {
    <?php if (session()->has("not_admin")) : ?>
      Swal.fire({
        icon: 'warning',
        title: 'Peringatan!',
        text: '<?= session("not_admin") ?>'
      })
    <?php endif; ?>
  });
</script>
<?= $this->endSection(); ?>