<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= ucwords($page_title); ?> - Dashboard Page</title>
  <script src="/js/jquery-3.6.3.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script> -->

  <!-- Custom styles for this template -->
  <link href="/css/dashboard.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
  <!-- @include('sweetalert::alert') -->
  <?= $this->include('dashboard/templates/header'); ?>


  <div class="container-fluid">
    <div class="row">
      <?= $this->include('dashboard/templates/sidebar'); ?>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <?= $this->renderSection('content'); ?>
      </main>
    </div>
  </div>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

  <!-- <script src="/js/moment-with-locales.min.js"></script>
  <script src="/js/pdfobject.js"></script>
  {{-- <script src="/js/dist/clipboard.min.js"></script> --}} -->

  <script src="<?= base_url('/js/dashboard.js'); ?>"></script>
</body>

</html>