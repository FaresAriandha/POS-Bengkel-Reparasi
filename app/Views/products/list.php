<?= $this->extend('dashboard/templates/main'); ?>

<?= $this->section('content'); ?>
<div class="row my-5">
  <h1>Daftar Produk</h1>
  <div class="add-search d-flex w-full justify-content-between mt-3 mb-3">
    <a href="/products/add" class="btn btn-primary h-fit">Tambah Produk</a>
    <form class="d-flex" role="search" action="/products" method="GET">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">
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
          <th scope="col">Jumlah Tersedia (pcs)</th>
          <th scope="col">Harga per satuan</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; ?>
        <?php if (count($products) > 0) : ?>
          <?php foreach ($products as $product) : ?>
            <tr>
              <th scope="row" class="text-center"><?= isset($_GET['page_products']) ? $no + ($_GET['page_products'] - 1) * $pagination : $no; ?></th>
              <td><?= $product['nama_barang']; ?></td>
              <td class="text-center"><img src="<?= base_url('img/uploads/products/' . $product['foto_barang']); ?>" alt="" width="150" height="100"></td>
              <td class="text-center"><?= $product['jenis_barang']; ?></td>
              <td class="text-center"><?= $product['kuantitas']; ?></td>
              <td class="text-center">Rp. <?= number_format($product['harga_per_satuan']); ?></td>
              <td class="align-middle text-center">
                <div class="w-full d-flex justify-content-center gap-3 ">
                  <a href="/products/delete/<?= $product['id']; ?>" type="button" class="btn btn-danger btn-delete"><i class="bi bi-trash"></i></a>
                  <a href="/products/edit/<?= $product['id']; ?>" class="btn btn-success"><i class="bi bi-pencil-square"></i></a>
                </div>
              </td>
            </tr>
            <?php $no++ ?>
          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td colspan="7">
              <h3>Maaf, produk belum tersedia</h3>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <?= $pager->links("products", "pagination"); ?>
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

    $('.btn-delete').on('click', function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Apakah kamu yakin menghapusnya?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batalkan',
        confirmButtonText: 'Ya, hapus data!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = `${$(this).attr('href')}`;
        }
      })
    })
  });
</script>
<?= $this->endSection(); ?>