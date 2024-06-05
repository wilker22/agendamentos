<?php echo $this->extend('Back/Layout/main'); ?>

<?php echo $this->section('title') ?>
<?php echo $title ?? 'Home'; ?>
<?php echo $this->endSection() ?>

<?php echo $this->section('css') ?>

<?php echo $this->endSection() ?>


<?php echo $this->section('content') ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo $title ?? 'Home'; ?></h6>
            <a href="<?= base_url(route_to('services.new')) ?>" class="btn btn-success float-right">Nova</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?php echo $services ?>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php echo $this->endSection() ?>


<?php echo $this->section('js') ?>

<?php echo $this->endSection() ?>