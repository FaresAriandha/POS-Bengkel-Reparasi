<?= $this->extend('templates/main') ?>

<?= $this->section('content')  ?>
<div class="vh-100 vw-100 d-flex align-items-center justify-content-center overflow-hidden" style="background-image: url('img/login.jpg'); background-repeat: no-repeat; background-size: cover;">
  <div class="col-lg-4">
    <main class="form-signin w-100 mb-3">
      <div class="w-100 d-flex flex-column justify-content-between align-items-center mb-4" style="height: 100px;">
        <img src="img/google.png" alt="" width="50" height="50" class="-top-3">
        <h1 class="h2 mb-4 mt-2 fw-semibold text-center fs-2">Please Login</h1>
      </div>
      <?php $error = session()->get('_ci_validation_errors'); ?>

      <?php if (session()->getFlashdata('not_found')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong><?= session()->getFlashdata('not_found'); ?></strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('logout')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong><?= session()->getFlashdata('logout'); ?></strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('not_login')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong><?= session()->getFlashdata('not_login'); ?></strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>
      <form action="/login" method="post">
        <div class="form-floating mb-3">
          <input type="username" class="form-control <?= isset($error['username']) ? 'is-invalid' : ''; ?>" id="username" name="username" placeholder="name@example.com" value="" autofocus>
          <label for="username">Username</label>
          <div class="invalid-feedback">
            <?= isset($error['username']) ? $error['username'] : ''; ?>
          </div>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control <?= isset($error['username']) ? 'is-invalid' : ''; ?>" name="password" id="password" placeholder="Password">
          <label for="password">Password</label>
          <div class="invalid-feedback">
            <?= isset($error['username']) ? $error['username'] : ''; ?>
          </div>
        </div>

        <button class="w-100 btn btn-lg btn-danger mt-4" type="submit">Login</button>
      </form>
    </main>

    <span class="fs-5 mt-2 d-flex align-items-center justify-content-center">Login With<a href="" class="d-inline-block ms-2"><img src="img/google.png" width="28" height="28"></a></span>
    <small class="d-block mt-3 text-center">Not registered ? <a href="/register" class="text-decoration-none">Register Now!</a></small>
  </div>
</div>
<?= $this->endSection(); ?>