<?= $this->extend('templates/main'); ?>

<?= $this->section('content'); ?>
<div class="vw-100 vh-100 d-flex align-items-center justify-content-center" style="background-image: url('img/register.jpg'); background-repeat: no-repeat; background-size: cover;">
  <div class="col-8 col-lg-4 p-3" style="
background: rgba(255, 255, 255, 0.2);
border-radius: 16px;
box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
backdrop-filter: blur(5px);
-webkit-backdrop-filter: blur(5px);
border: 1px solid rgba(255, 255, 255, 0.3);">
    <main class="form-signin w-100 mb-3">
      <div class="w-100 d-flex flex-column justify-content-between align-items-center mb-4" style="height: 100px;">
        <img src="img/google.png" alt="" width="50" height="50" class="-top-3">
        <h1 class="h2 mb-4 fw-semibold text-center fs-2">Please Register</h1>
      </div>
      <?php $error = session()->get('_ci_validation_errors'); ?>
      <form action="/register/store" method="post">
        <div class="form-floating mb-3">
          <input type="text" class="form-control <?= isset($error['username']) ? 'is-invalid' : ''; ?>" id="username" name="username" placeholder="Your Username" value="<?= old('username'); ?>" autofocus>
          <label for="username">Username</label>
          <div class="invalid-feedback">
            <?= isset($error['username']) ? $error['username'] : ''; ?>
          </div>
        </div>
        <div class="form-floating mb-3">
          <input type="email" class="form-control <?= isset($error['email']) ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="name@example.com" value="<?= old('email'); ?>">
          <label for="email">Email</label>
          <div class="invalid-feedback">
            <?= isset($error['email']) ? $error['email'] : ''; ?>
          </div>
        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control rounded-bottom <?= isset($error['password']) ? 'is-invalid' : ''; ?>" name="password" id="password" placeholder="Password">
          <label for="password">Password</label>
          <div class="invalid-feedback">
            <?= isset($error['password']) ? $error['password'] : ''; ?>
          </div>
        </div>

        <button class="w-100 btn btn-lg btn-success mt-4" type="submit">Register</button>
      </form>
    </main>

    <small class="d-block mt-3 text-center">Already registered ? <a href="<?= base_url('/login'); ?>" class="text-decoration-none">Login</a></small>
  </div>
</div>
<?= $this->endSection('content'); ?>