<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page_title; ?></title>
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->

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

<body>

  <?php
  // $path = dirname('/img/google.png');
  // $type = pathinfo($path, PATHINFO_EXTENSION);
  // dd($path);
  // $photo = file_get_contents($path);
  // $base64 = 'photo:image/' . $type . ';base64,' . base64_encode($photo);
  // dd($dompdf->loadHtmlFile('/img/google.png'));
  ?>
  <div style="padding: 0 50px;">
    <!-- Header -->
    <div style="border-bottom: 3px solid black; padding-bottom: 10px; position: relative; height: fit-content;">
      <div style="width: fit-content; float: left;">
        <!-- <img src="/img/google.png" alt="" width="100" height="100" style="float: left;"> -->
        <div style="width: fit-content; float: left;">
          <h3 style="margin: 0 0 15px 0;">Bengkel Ucok</h3>
          <p style="margin: 0;">Jl. Lorem ipsum dolor sit amet.</p>
          <p style="margin: 0;">Telp. 0849348934 / 0219328932</p>
          <p style="margin: 0;">www.ucok-bengkel.com</p>
        </div>
      </div>
      <div style="height: 100px; float: right;">
        <h3 style="margin: 0; line-height: 100px; letter-spacing: 3px;">INVOICE PEMBAYARAN</h3>
      </div>
      <div style="clear: both;"></div>
    </div>

    <!-- Content -->
    <div style="width: 100%;">
      <h4 style="margin-bottom: 10px;">Kepada Yth.</h4>
      <div style="width: 100%; margin: 0; padding: 0;">
        <div style="width: fit-content; float: left;">
          <table>
            <tbody>
              <tr>
                <th style=" text-align: left;">Nama</th>
                <td style="display: inline-block; padding: 0 8px;"></td>
                <td style="text-align: left;"><?= $data[0]['nama_pembeli']; ?></td>
              </tr>
              <tr>
                <th style="text-align: left;">No. Telp</th>
                <td style="display: inline-block; padding: 0 8px;"></td>
                <td style="text-align: left;"><?= $data[0]['no_tlp']; ?></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="info-transaksi" style="width: fit-content; float: right; margin-right: 100px;">
          <table style="text-align: left;">
            <tbody>
              <tr>
                <th style="text-align: left;">Kasir</th>
                <td style="display: inline-block; padding: 0 8px;"></td>
                <td style="text-align: left;"><?= $data[0]['nama_karyawan']; ?></td>
              </tr>
              <tr>
                <th style="text-align: left;">ID Pesanan</th>
                <td style="display: inline-block; padding: 0 8px;"></td>
                <td style="text-align: left;"><?= $data[0]['id_pesanan']; ?></td>
              </tr>
              <tr>
                <th style="text-align: left;">Tanggal Pembelian</th>
                <td style="display: inline-block; padding: 0 8px;"></td>
                <td style="text-align: left;"><?= date_format(date_create($data[0]['tgl_pemesanan']), "d-m-Y, H:i"); ?></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div style="clear: both;"></div>
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
              <td style="text-align: right;">Rp. <?= number_format($d['total_harga_per_barang']); ?></td>
            </tr>
            <?php $total_harga += $d['total_harga_per_barang']; ?>
          <?php endforeach; ?>
          <tr id="total_belanja">
            <td colspan="4" style="text-align: center;">Total Harga</td>
            <td style="text-align: right;">Rp. <?= number_format($total_harga); ?></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div style="width: 100%; display: flex; margin-top: 20px; justify-content: end;">
      <div class="ttd" style="width: fit-content; float: right; text-align: center;">
        <h4>Depok, <?= date_format(date_create($data[0]['tgl_pemesanan']), "d-m-Y"); ?></h4>
        <span>ttd</span>
        <p>(<span style="font-weight: 500;">Bengkel Ucok</span>)</p>
      </div>
    </div>
  </div>
</body>

</html>