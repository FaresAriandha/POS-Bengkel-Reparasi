<?= $this->extend('dashboard/templates/main'); ?>

<?= $this->section('content'); ?>
<div class="row mt-3 mb-5 px-3">
  <h1 class="my-3">Edit Profil Akun</h1>
  <div class="col-lg-6 border border-2 rounded-3 p-3 shadow">
    <?php $error = session()->get('_ci_validation_errors'); ?>
    <form action="/users/update" method="post" class="d-flex flex-column" id="updateakun">
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <div class="input-group">
          <input type="text" class="form-control rounded-0 bg-secondary bg-opacity-25 <?= isset($error['email']) ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="ucup@gmail.com" value="<?= old('email') ? old('email') : $user['email']; ?>" readonly>
          <button class="btn btn-warning text-white btn-email" type="button"><i class="bi bi-pencil text-dark"></i></button>
          <div class="invalid-feedback">
            <?= isset($error['email']) ? $error['email'] : ''; ?>
          </div>
        </div>
      </div>
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <div class="input-group">
          <input type="text" class="form-control rounded-0 bg-secondary bg-opacity-25 <?= isset($error['username']) ? 'is-invalid' : ''; ?>" id="username" name="username" placeholder="ucup123" value="<?= old('username') ? old('username') : $user['username']; ?>" readonly>
          <button class="btn btn-warning text-white btn-username" type="button"><i class="bi bi-pencil text-dark"></i></button>
          <div class="invalid-feedback">
            <?= isset($error['username']) ? $error['username'] : ''; ?>
          </div>
        </div>
      </div>
      <div class="mb-3">
        <label for="old-password" class="form-label">Password Lama</label>
        <div class="input-group">
          <input type="password" class="form-control rounded-0 passchange bg-secondary bg-opacity-25 <?= isset($error['old-password']) ? 'is-invalid' : ''; ?>" id="old-password" name="old-password" value="<?= old('old-password'); ?>" placeholder="Password saat ini" readonly>
          <button class="btn btn-warning text-white btn-password rounded-0" type="button"><i class="bi bi-pencil text-dark"></i></button>
        </div>
        <span class="info-password"></span>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password Baru</label>
        <div class="input-group">
          <input type="password" class="form-control rounded-0 passchange bg-secondary bg-opacity-25 <?= isset($error['password']) ? 'is-invalid' : ''; ?>" id="password" name="password" value="<?= old('password'); ?>" placeholder="Password terbaru" readonly>
          <div class="invalid-feedback">
            <?= isset($error['password']) ? $error['password'] : ''; ?>
          </div>
        </div>
      </div>
      <div class="button align-self-end">
        <button type="button" id="btn-update" class="btn btn-success">Ubah</button>
      </div>
    </form>
  </div>
</div>


<script>
  <?php if (session()->has("update")) : ?>
    Swal.fire({
      icon: 'success',
      title: 'Sukses!',
      text: '<?= session("update") ?>'
    })
  <?php endif; ?>

  <?php if (session()->has("other")) : ?>
    Swal.fire({
      icon: 'warning',
      title: 'Peringatan!',
      text: '<?= session("other") ?>'
    })
  <?php endif; ?>

  $('.btn-password').on('click', function() {
    if ($('.passchange').attr('readonly')) {
      $('.passchange').removeAttr('readonly');
      $('.passchange').removeClass('bg-secondary');
      return false;
    }
    $('.passchange').attr('readonly', true);
    $('.passchange').addClass('bg-secondary', true);
  })

  $('.btn-username').on('click', function() {
    if ($('#username').attr('readonly')) {
      $('#username').removeAttr('readonly');
      $('#username').removeClass('bg-secondary');
      return false;
    }
    $('#username').attr('readonly', true);
    $('#username').addClass('bg-secondary', true);
  })

  $('.btn-email').on('click', function() {
    if ($('#email').attr('readonly')) {
      $('#email').removeAttr('readonly');
      $('#email').removeClass('bg-secondary');
      return false;
    }
    $('#email').attr('readonly', true);
    $('#email').addClass('bg-secondary', true);
  })

  $('#old-password').on('change', function() {
    let username = '<?= session()->get('logged_in')['username']; ?>';
    let password = $(this).val();
    fetch(`http://localhost:8081/users/show`, {
        method: "post",
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },

        //make sure to serialize your JSON body
        body: JSON.stringify({
          username,
          password
        })
      })
      .then(response => response.json())
      .then(response => {
        if (response.status == 200) {
          Swal.fire({
            icon: 'success',
            title: 'Password ditemukan',
            text: 'Password benar dan cocok'
          })
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Password tidak ditemukan',
            text: 'Harap cek password anda'
          })
        }
      })
    // .catch(err => console.log(err))
  })

  $('#btn-update').on('click', function() {
    Swal.fire({
      title: 'Apakah kamu yakin perbarui data?',
      text: "Data akun akan berubah, simpan dengan baik!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batalkan',
      confirmButtonText: 'Ya'
    }).then((result) => {
      if (result.isConfirmed) {
        $('#updateakun').submit();
      }
    })
  })
</script>
<?= $this->endSection(); ?>