<?= $this->extend('dashboard/templates/main'); ?>

<?= $this->section('content'); ?>
<div class="row my-5">
  <h1>Daftar Transaksi</h1>
  <div class="add-search d-flex w-full justify-content-between mt-3 mb-3">
    <form class="d-flex" role="search" action="/transactions" method="GET">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>

  </div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead class="bg-secondary text-white text-center align-middle">
        <tr>
          <th scope="col">#</th>
          <th scope="col">ID Pesanan</th>
          <th scope="col">Status Transaksi</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; ?>
        <?php if (count($transactions) > 0) : ?>
          <?php foreach ($transactions as $trx) : ?>
            <tr>
              <th scope="row" class="text-center"><?= isset($_GET['page_transactions']) ? $no + ($_GET['page_transactions'] - 1) * $pagination : $no; ?></th>
              <td class="text-center"><?= $trx['id_pesanan']; ?></td>
              <?php
              $bg_badge = '';
              if ($trx['status'] == 'pending') {
                $bg_badge = 'bg-warning';
              } elseif ($trx['status'] == 'sukses') {
                $bg_badge = 'bg-success';
              } else {
                $bg_badge = 'bg-danger';
              }
              ?>
              <td class="text-center"><span class="badge <?= $bg_badge; ?> fs-6"><?= ucfirst($trx['status']); ?></span></td>
              <td class="w-full d-flex justify-content-center gap-3">
                <?php if ($trx['status'] == 'sukses') : ?>
                  <a href="/transactions/print/<?= $trx['id_pesanan']; ?>" class="btn btn-success"><i class="bi bi-pencil-square"></i></a>
                <?php endif; ?>
              </td>
            </tr>
            <?php $no++ ?>
          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td colspan="7">
              <h3>Maaf, transaksi belum tersedia</h3>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <?= $pager->links("transactions", "pagination"); ?>
</div>



<script>
  $(function() {
    <?php if (session()->has("add")) : ?>
      Swal.fire({
        icon: 'success',
        title: 'Sukses!',
        text: '<?= session("add") ?>'
      })
    <?php endif; ?>

    <?php if (session()->has("delete")) : ?>
      Swal.fire({
        icon: 'success',
        title: 'Sukses!',
        text: '<?= session("delete") ?>'
      })
    <?php endif; ?>

    <?php if (session()->has("update")) : ?>
      Swal.fire({
        icon: 'success',
        title: 'Sukses!',
        text: '<?= session("update") ?>'
      })
    <?php endif; ?>
  });
</script>
<?= $this->endSection(); ?>