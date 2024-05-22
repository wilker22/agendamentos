<?php echo $this->extend('Back/Layout/main'); ?>

<?php echo $this->section('title') ?>
<?php echo $title ?? 'Home'; ?>
<?php echo $this->endSection() ?>

<?php echo $this->section('css') ?>

<?php echo $this->endSection() ?>


<?php echo $this->section('content') ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?? 'Home'; ?></h1>

    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?php echo $units ?>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php echo $this->endSection() ?>


<?php echo $this->section('js') ?>

<?php echo $this->endSection() ?>