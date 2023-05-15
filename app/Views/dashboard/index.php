<?= $this->extend('dashboard/templates/main'); ?>

<?= $this->section('content'); ?>

<h1>Halo, ini saya <?= session()->get('logged_in')['username']; ?></h1>

<?= $this->endSection(); ?>