<?= $this->extend('dashboard/templates/main'); ?>

<?= $this->section('content'); ?>
<div class="row my-5">
  <h1>Daftar Karyawan</h1>
  <div class="add-search d-flex w-full justify-content-between mt-3 mb-3">
    <a href="/employees/add" class="btn btn-primary h-fit">Tambah Karyawan</a>
    <form class="d-flex" role="search" action="/employees" method="GET">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>

  </div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead class="bg-secondary text-white text-center align-middle">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nama Karyawan</th>
          <th scope="col">Foto Karyawan</th>
          <th scope="col">Jenis Kelamin</th>
          <th scope="col">Role</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; ?>
        <?php if (count($employees) > 0) : ?>
          <?php foreach ($employees as $employee) : ?>
            <tr>
              <th scope="row" class="text-center"><?= isset($_GET['page_employees']) ? $no + ($_GET['page_employees'] - 1) * $pagination : $no; ?></th>
              <td><?= $employee['nama_karyawan']; ?></td>
              <td class="text-center"><img src="<?= base_url('img/uploads/employees/' . $employee['foto_karyawan']); ?>" alt="" width="150" height="100"></td>
              <td class="text-center"><?= $employee['jenis_kelamin']; ?></td>
              <td class="text-center"><span class="badge <?= $employee['role'] == "admin" ? 'bg-primary' : 'bg-warning'; ?> fs-6"><?= ucfirst($employee['role']); ?></span></td>
              <td class="w-full d-flex justify-content-center align-items-center gap-3">
                <a href="/employees/delete/<?= $employee['id']; ?>" type="button" class="btn btn-danger btn-delete"><i class="bi bi-trash"></i></a>
                <button class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $employee['id']; ?>" data-><i class="bi bi-info-circle"></i></button>
                <a href="/employees/edit/<?= $employee['id']; ?>" class="btn btn-success"><i class="bi bi-pencil-square"></i></a>
              </td>
            </tr>
            <?php $no++ ?>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal<?= $employee['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Data <?= $employee['nama_karyawan']; ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="d-flex flex-wrap justify-content-start gap-3">
                      <img src="<?= base_url('img/uploads/employees/' . $employee['foto_karyawan']); ?>" alt="" width="250" height="200">
                      <div class="col-10 col-lg-7">
                        <ul class="list-group">
                          <li class="list-group-item">
                            <span class="fw-bold">Nama Lengkap</span>
                            <span class="d-block fs-6"><?= $employee['nama_karyawan']; ?></span>
                          </li>
                          <li class="list-group-item">
                            <span class="fw-bold">Jenis Kelamin</span>
                            <span class="d-block fs-6"><?= $employee['jenis_kelamin']; ?></span>
                          </li>
                          <li class="list-group-item">
                            <span class="fw-bold">Alamat</span>
                            <span class="d-block fs-6"><?= $employee['alamat']; ?></span>
                          </li>
                          <li class="list-group-item">
                            <span class="fw-bold">No. Tlp</span>
                            <span class="d-block fs-6"><?= $employee['no_tlp']; ?></span>
                          </li>
                          <li class="list-group-item">
                            <span class="fw-bold">Email</span>
                            <span class="d-block fs-6"><?= $employee['email']; ?></span>
                          </li>
                          <h3 class="my-3">Akun</h3>
                          <li class="list-group-item">
                            <span class="fw-bold">Username</span>
                            <span class="d-block fs-6"><?= $employee['username']; ?></span>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td colspan="7">
              <h3>Maaf, karyawan belum ada</h3>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <?= $pager->links("employees", "pagination"); ?>
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