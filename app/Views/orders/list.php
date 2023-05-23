<?= $this->extend('dashboard/templates/main'); ?>

<?= $this->section('content'); ?>
<div class="row my-5">
  <h1>Daftar Pesanan</h1>
  <div class="add-search d-flex w-full justify-content-between mt-3 mb-3">
    <?php

    use App\Models\TransactionModel;

    $request = \Config\Services::request();
    $keyword = "";
    if ($request->getGet('keyword') && $request->getGet('keyword') != '') {
      $keyword = $request->getGet('keyword');
    }
    $trx = new TransactionModel()
    ?>
    <div class="button-group">
      <a href="/orders/add" class="btn btn-primary h-fit">Tambah Pesanan</a>
      <a href="<?= base_url('/orders/print?keyword=' . $keyword); ?>" class="btn btn-warning h-fit">Cetak XLS</a>
    </div>
    <form class="d-flex" role="search" action="/orders" method="GET">
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
          <th scope="col">Tanggal Pemesanan</th>
          <th scope="col">Total Barang</th>
          <th scope="col">Total Belanja</th>
          <th scope="col">Nama Pembeli</th>
          <th scope="col">Status Bayar</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; ?>
        <?php if (count($orders) > 0) : ?>
          <?php foreach ($orders as $order) : ?>
            <tr>
              <th scope="row" class="text-center"><?= isset($_GET['page_orders']) ? $no + ($_GET['page_orders'] - 1) * $pagination : $no; ?></th>
              <td class="text-center"><?= $order['id_pesanan']; ?></td>
              <td class="text-center"><?= date_format(date_create($order['tgl_pemesanan']), "d-m-Y, H:i") . " WIB"; ?></td>
              <td class="text-center"><?= number_format($order['total_barang']); ?></td>
              <td class="text-center">Rp. <?= number_format($order['total_harga']); ?></td>
              <td class="text-center"><?= $order['nama_pembeli']; ?></td>
              <?php
              $bg_badge = '';
              $status = $trx->where('id_pesanan', $order['id_pesanan'])->first()['status'];
              if ($status == 'pending') {
                $bg_badge = 'bg-warning';
              } elseif ($status == 'sukses') {
                $bg_badge = 'bg-success';
              }
              ?>
              <td class="text-center"><span class="badge fs-6 <?= $bg_badge; ?>"><?= $status; ?></span></td>
              <td class="align-middle text-center">
                <div class="w-full d-flex justify-content-center align-items-center gap-3">
                  <a href="/orders/delete/<?= $order['id_pesanan']; ?>" type="button" class="btn btn-danger btn-delete"><i class="bi bi-trash "></i></a>
                  <button class="btn btn-warning text-white btn-info-pesanan" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id-pesanan="<?= $order['id_pesanan']; ?>"><i class="bi bi-info-circle btn-info-pesanan" data-id-pesanan="<?= $order['id_pesanan']; ?>"></i></button>
                </div>
              </td>
            </tr>
            <?php $no++ ?>

          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td colspan="7">
              <h3>Maaf, Pesanan tidak ada</h3>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Data Pesanan</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="d-flex flex-wrap flex-column justify-content-start align-items-start gap-3 ">
              <div class="col-12 col-lg-5">
                <ul class="list-group">
                  <li class="list-group-item">
                    <span class="fw-bold">ID Pemesanan</span>
                    <span class="d-block fs-6" id="id_pesanan"></span>
                  </li>
                  <li class="list-group-item">
                    <span class="fw-bold">Nama Pembeli</span>
                    <span class="d-block fs-6" id="nama_pembeli"></span>
                  </li>
                  <li class="list-group-item">
                    <span class="fw-bold">Tanggal Pemesanan</span>
                    <span class="d-block fs-6" id="tgl_pemesanan"></span>
                  </li>
                </ul>
              </div>
              <div class="table-responsive col-12">
                <table class="table table-bordered align-middle col-5">
                  <thead class="bg-secondary text-white text-center align-middle">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Nama Barang</th>
                      <th scope="col">Jumlah Barang</th>
                      <th scope="col">Harga Satuan</th>
                      <th scope="col">Total Harga</th>
                    </tr>
                  </thead>
                  <tbody id="modal-table">
                    <!-- <tr>
                      <th scope="row" class="text-center">1</th>
                      <td></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-end"></td>
                    </tr>
                    <tr id="total_belanja">
                      <td colspan="4" class="text-center"></td>
                      <td class="text-end"></td>
                    </tr> -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer d-none">
            <a href='/transactions/update' type="button" class="btn btn-success" id="btn-bayar">Sudah Bayar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?= $pager->links("orders", "pagination"); ?>
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
        title: 'Print Bukti Transaksi',
        text: "Apakah anda ingin mencetaknya?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Nanti saja',
        confirmButtonText: 'Ya, print!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = '<?= session("update") ?>';
        }
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


    // Create our number formatter.
    const formatter = new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      maximumFractionDigits: 0
    });

    const templateModalDetailPesanan = (data) => {
      let str = '';
      let no = 0;

      const options = {
        year: "numeric",
        month: "long",
        day: "numeric",
        hours: "numeric",
      };
      $("#id_pesanan").text(data.orders[0].id_pesanan)
      $("#nama_pembeli").text(data.orders[0].nama_pembeli)
      $(".modal-header h1").text(`Data Pesanan ${data.orders[0].id_pesanan}`)

      if (data.status == 'pending') {
        $('.modal-footer').removeClass('d-none')
        $("#btn-bayar").attr('href', `/transactions/update/${data.orders[0].id_pesanan}`)
      } else {
        $('.modal-footer').addClass('d-none')
      }


      const date = new Date(data.orders[0].tgl_pemesanan)
      $("#tgl_pemesanan").text(`${date.toLocaleString('id-ID', options)}, ${date.getHours()}:${date.getMinutes()} WIB`)

      data.orders.forEach(d => {
        str += `<tr>
                      <th scope="row" class="text-center">${++no}</th>
                      <td>${d.nama_barang}</td>
                      <td class="text-center">${d.jumlah}</td>
                      <td class="text-center">${formatter.format(d.harga_barang)}</td>
                      <td class="text-end">${formatter.format(d.total_harga_per_barang)}</td>
                    </tr>`;
      });

      str += `<tr id="total_belanja">
                      <td colspan="4" class="text-center">Total Belanja</td>
                      <td class="text-end">${formatter.format(data.price.total_belanja)}</td>
                    </tr>`

      $('#modal-table').html(str);
      $('#exampleModal').modal('show');
    }

    $("body").on('click', function(e) {
      if ($(e.target).hasClass('btn-info-pesanan')) {
        const data = {
          id: $(e.target).data('id-pesanan')
        }

        fetch(`http://localhost:8081/orders/show?id=${data.id}`, {
            METHOD: 'GET',
          })
          .then(response => response.json())
          .then(response => templateModalDetailPesanan(response.data))
      }

    })
  });
</script>
<?= $this->endSection(); ?>