<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UTS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <style>
    table#content-barang,
    table#content-barang th,
    table#content-barang td {
      border: 2px solid #d9d9d9;
      border-collapse: collapse;
      padding: 5px 5px;
    }
  </style>

</head>

<body style="display: flex; justify-content: center;">

  <?php
  // $path = dirname('/img/google.png');
  // $type = pathinfo($path, PATHINFO_EXTENSION);
  // dd($path);
  // $photo = file_get_contents($path);
  // $base64 = 'photo:image/' . $type . ';base64,' . base64_encode($photo);
  define("DOMPDF_ENABLE_REMOTE", false);
  ?>
  <div style="width: 1200px; margin: 100px 0 20px; padding: 0 50px;">
    <!-- Header -->
    <div style="border-bottom: 3px solid black; padding-bottom: 10px;">
      <div style="width: 100%; display: flex; justify-content: space-between; align-items: center;">
        <div style="width: fit-content; display: flex; justify-content: flex-start; align-items: center;">
          <img src="<?= $_SERVER['DOCUMENT_ROOT'] . '\img\google.png'; ?>" alt="" width="100" height="100">
          <div style="width: fit-content; display: flex; flex-direction: column; margin-left: 16px;">
            <h4>Bengkel Ucok</h4>
            <p style="margin: 0;">Jl. Lorem ipsum dolor sit amet.</p>
            <p style="margin: 0;">Telp. 0849348934 / 0219328932</p>
            <p style="margin: 0;">www.ucok-bengkel.com</p>
          </div>
        </div>
        <h3>INVOICE</h3>
      </div>
    </div>

    <!-- Content -->
    <div style="width: 100%; margin-top: 20px;">
      <h5 style="margin-bottom: 0;">Kepada Yth.</h5>
      <div style="width: 100%; display: flex; justify-content: space-between; align-items: center;">
        <div style="width: fit-content; display: flex; flex-direction: column; justify-content: flex-start;">
          <table>
            <tbody>
              <tr>
                <th>Nama</th>
                <td style="display: inline-block; padding: 0 8px;"></td>
                <td><?= $data[0]['nama_pembeli']; ?></td>
              </tr>
              <tr>
                <th>No. Telp</th>
                <td style="display: inline-block; padding: 0 8px;"></td>
                <td><?= $data[0]['no_tlp']; ?></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="info-transaksi" style="width: fit-content; display: flex; flex-direction: column; justify-content: flex-start; margin-right: 100px;">
          <table>
            <tbody>
              <tr>
                <th>Kasir</th>
                <td style="display: inline-block; padding: 0 8px;"></td>
                <td><?= $data[0]['nama_karyawan']; ?></td>
              </tr>
              <tr>
                <th>ID Pesanan</th>
                <td style="display: inline-block; padding: 0 8px;"></td>
                <td><?= $data[0]['id_pesanan']; ?></td>
              </tr>
              <tr>
                <th>Tanggal Pembelian</th>
                <td style="display: inline-block; padding: 0 8px;"></td>
                <td><?= date_format(date_create($data[0]['tgl_pemesanan']), "d-m-Y, H:i"); ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <table id="content-barang" style="width:100%; margin: 20px 0; border: 2px solid white; border-collapse: collapse;">
        <!-- style="background-color: black; color: white;" -->
        <thead style="color: white; text-align: center; background-color: #666666;">
          <tr>
            <th>#</th>
            <th>Nama Barang</th>
            <th>Jumlah Barang</th>
            <th>Harga Satuan</th>
            <th>Total Harga</th>
          </tr>
        </thead>
        <tbody id="modal-table">
          <?php $no = 0;
          $total_harga = 0; ?>
          <?php foreach ($data as $d) : ?>
            <tr>
              <th style="text-align: center;"><?= ++$no; ?></th>
              <td><?= $d['nama_barang']; ?></td>
              <td style="text-align: center;"><?= number_format($d['jumlah']); ?></td>
              <td style="text-align: center;">Rp. <?= number_format($d['harga_barang']); ?></td>
              <td style="text-align: end;">Rp. <?= number_format($d['total_harga_per_barang']); ?></td>
            </tr>
            <?php $total_harga += $d['total_harga_per_barang']; ?>
          <?php endforeach; ?>
          <tr id="total_belanja">
            <td colspan="4" style="text-align: center;">Total Harga</td>
            <td style="text-align: end;">Rp. <?= number_format($total_harga); ?></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div style="width: 100%; display: flex; margin-top: 50px; justify-content: end;">
      <div class="ttd" style="width: fit-content; display: flex; flex-direction: column; align-items: center;">
        <h6>Depok, <?= date_format(date_create($data[0]['tgl_pemesanan']), "d-m-Y"); ?></h6>
        <img src="<?= base_url('/img/ttd.png'); ?>" alt="" width="100">
        <p>(<span style="font-weight: 500;">Bengkel Ucok</span>)</p>
      </div>
    </div>
  </div>
</body>

</html>