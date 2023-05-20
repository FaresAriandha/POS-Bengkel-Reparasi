<?= $this->extend('dashboard/templates/main'); ?>

<?= $this->section('content'); ?>
<div class="card rounded-0 my-5">
  <div class="card-header">
    <div class="d-flex w-100 justify-content-between">
      <div class="card-title h4 mb-0 fw-bolder">Tambah Pesanan</div>
    </div>
  </div>
  <div class="card-body px-0">
    <div class="container-fluid">
      <div class="row align-items-end gap-3">
        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
          <label for="id_barang" class="control-label mb-2">Pilih Produk</label>
          <select id="id_barang" class="form-select rounded-0">
            <option value="" disabled selected>Pilih salah satu</option>
            <?php
            foreach ($products as $row) :
            ?>
              <option value="<?= $row['id'] ?>" data-price="<?= $row['harga_per_satuan'] ?>"><?= $row['nama_barang'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
          <label for="jumlah" class="control-label mb-2">Jumlah Produk <span class="fw-semibold stok"></span></label>
          <div class="input-group">
            <input type="number" class="form-control  <?= isset($error['kuantitas']) ? 'is-invalid' : ''; ?>" id="jumlah" name="jumlah" placeholder="0">
            <span class="input-group-text" id="basic-addon1">Qty</span>
            <div class="invalid-feedback">
            </div>
          </div>
        </div>
      </div>
      <button class="btn btn-success btn-sm mt-3" type="button" id="add_item">Tambah Item</button>
    </div>
    <hr>

    <!-- Form Data Produk -->
    <form action="/orders/store" id="transaction-form" method="POST">
      <input type="hidden" value="" id="data_nama_barang" name="data_nama_barang">
      <input type="hidden" value="" id="data_subtotal" name="data_subtotal">
      <input type="hidden" value="" id="data_jumlah" name="data_jumlah">
      <div class="container-fluid">
        <div class="table-responsive">
          <table class="table table-bordered align-middle">
            <thead>
              <tr class="bg-gradient bg-secondary text-light">
                <th class="p-1 text-center"></th>
                <th class="p-1 text-center">Nama Produk</th>
                <th class="p-1 text-center">Kuantitas</th>
                <th class="p-1 text-center">Harga Satuan</th>
                <th class="p-1 text-center">Total Harga</th>
              </tr>
            </thead>
            <tbody id="list_products">
            </tbody>
          </table>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered">
            <colgroup>
              <col width="5%">
              <col width="15%">
              <col width="30%">
              <col width="20%">
              <col width="20%">
            </colgroup>
            <tfoot>
              <tr class="bg-warning bg-gradient bg-opacity-25 text-dark">
                <th class="p-1 text-center" colspan="4">Total Bayar</th>
                <th class="p-1 text-end h4 mb-0" id="gtotal">0</th>
              </tr>
            </tfoot>
          </table>
        </div>

        <!-- Ini Data Diri Pembeli -->
        <div class="row gap-3">
          <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
            <label for="nama_pembeli" class="control-label mb-2">Nama Pembeli</label>
            <input type="text" class="form-control rounded-0" id="nama_pembeli" name="nama_pembeli" required="required">
          </div>

          <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
            <label for="no_tlp" class="control-label mb-2">No. Telp Pembeli</label>
            <input type="number" class="form-control rounded-0" id="no_tlp" name="no_tlp" required="required" maxlength="14">
          </div>

          <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
            <label for="uang_pembeli" class="control-label mb-2">Jumlah Uang Pembeli</label>
            <input type="number" class="form-control rounded-0" id="uang_pembeli" name="uang_pembeli" required="required">
          </div>

          <div class="h4 my-3 fw-bolder text-end"><span class="text-muted">Kembalian : </span> <span class="ms-2" id="change">0</span></div>
        </div>
      </div>
    </form>
  </div>
  <div class="card-footer text-center">
    <button class="btn btn-primary save_transaction" type="button">Tambah Pemesanan</button>
  </div>
</div>
</div>

<script>
  $(function() {
    let subtotal = 0;
    // Create our number formatter.
    const formatter = new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      maximumFractionDigits: 0
    });

    const calculate_total = () => {
      subtotal = 0;
      if ($('.subtotal').length <= 0) {
        $('#gtotal').text(0)
        return false;
      }
      $('.subtotal').each((i, e) => {
        subtotal += parseInt($(e).val(), 10);
        $('#gtotal').text(formatter.format(subtotal))
      })
    }

    const dataBarang = (data, selector) => {
      let arr = []
      $(selector).each((i, e) => {
        if (data == 'nama_barang') {
          arr.push($(e).val())
        } else {
          arr.push(parseInt($(e).val()))
        }
      })
      return arr
    }
    const templateBarisProduk = (data) => {
      let str = `<tr>
                <td class="p-1 text-center opt-delete">
                  <button type="button" class="btn btn-danger p-0"><i class="bi bi-trash btn-delete px-2 py-1"></i></button>
                </td>
                <td class="p-0 text-center">
                  <input class="form-control col-4 rounded-0 bg-white border-0 nama_barang" type="text" name="product_name[]" disabled value="${data.nama_barang}">
                </td>
                <td class="p-0 text-center">
                  <input class="form-control col-4 rounded-0 bg-white border-0 text-center jumlah" type="number" name="product_qty[]" disabled value="${data.qty}" placeholder="0">
                </td>
                <td class="p-0 text-center">
                  <input class="form-control col-4 rounded-0 bg-white border-0 text-center" type="number" name="product_unit_price[]" disabled value="${data.harga_per_satuan}" placeholder="0">
                </td>
                <td class="p-0 text-center">
                  <input class="form-control col-4 rounded-0 bg-white border-0 text-end subtotal" type="number" name="product_subtotal[]" disabled value="${data.harga_per_satuan * data.qty}" placeholder="0">
                </td>
                </tr>`;

      $('#list_products').append(str);
    }

    $('#add_item').on('click', function() {
      let id = $('#id_barang').val();

      if ($('#id_barang').val() == '' || $('#jumlah').val() == 0) {
        Swal.fire({
          icon: 'warning',
          title: 'Peringatan!',
          text: 'Harap isi dengan benar!'
        })
        return false
      }
      fetch(`http://localhost:8081/orders/detail-product?id=${id}`, {
          METHOD: 'GET',
        })
        .then(response => response.json())
        .then(response => {
          response.product.qty = parseInt($('#jumlah').val())
          if (response.product.qty > response.product.kuantitas) {
            Swal.fire({
              icon: 'warning',
              title: 'Peringatan!',
              text: `Barang ${response.product.nama_barang} hanya tersedia ${response.product.kuantitas} stok`
            })
            $('#id_barang').val('')
            $('#jumlah').val('')
            return false
          }
          templateBarisProduk(response.product)
          $('#id_barang').val('')
          $('#jumlah').val('')

          calculate_total()
        })

    })

    $('#id_barang').on('change', function() {
      let id = $(this).val();
      fetch(`http://localhost:8081/orders/detail-product?id=${id}`, {
          METHOD: 'GET',
        })
        .then(response => response.json())
        .then(response => {
          $('.stok').text(`(Stok ${response.product.kuantitas})`)
        })

    })

    $('body').on('click', function(e) {
      if ($(e.target).hasClass('btn-delete')) {
        $(e.target).parent().parent().parent().empty();
      }
      calculate_total();
    })

    $('#uang_pembeli').on('change', function() {
      let tendered = parseInt($(this).val());
      var amount = subtotal
      tendered = tendered > 0 ? tendered : 0;
      amount = amount > 0 ? amount : 0;

      var change = parseFloat(tendered) - parseFloat(amount);
      if ($(this).val() == 0 || change < 0) {
        $('#change').text(formatter.format(0))
        Swal.fire({
          icon: 'warning',
          title: 'Peringatan!',
          text: 'Masih kurang nii bayarnya bos!'
        })
        return false
      }
      $('#change').text(formatter.format(change))
    })

    $('body').click(function(e) {
      if ($(e.target).hasClass('save_transaction')) {
        if ($('#list_products tr').length <= 0) {
          Swal.fire({
            icon: 'warning',
            title: 'Peringatan!',
            text: 'Minimal ada satu barang yang dibeli bos!'
          })
          return false;
        }

        if ($('#nama_pembeli').val() == '' || $('#no_tlp').val() == 0) {
          Swal.fire({
            icon: 'warning',
            title: 'Peringatan!',
            text: 'Kayaknya nama pembeli atau nomor teleponnya belum diisi bos!'
          })
          return false;
        }

        if ($('#uang_pembeli').val() == 0 || $('#uang_pembeli').val() < subtotal) {
          Swal.fire({
            icon: 'warning',
            title: 'Peringatan!',
            text: 'Masih kurang bayarnya!'
          })
          return false;
        }

        $('#data_nama_barang').val(dataBarang('nama_barang', '.nama_barang'))
        $('#data_subtotal').val(dataBarang('subtotal', '.subtotal'))
        $('#data_jumlah').val(dataBarang('jumlah', '.jumlah'))
        // console.log($('#data_subtotal').val());
        $('#transaction-form').submit()
      }
    })
  })
</script>
<?= $this->endSection(); ?>