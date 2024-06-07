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
            <a href="<?= base_url(route_to('units')) ?>" class="btn btn-secondary float-right">Voltar</a>
        </div>
        <div class="card-body">
            <?php form_open('units.services.store', $unit->id, hidden: ['_method' => 'PUT']) ?>
            <button type="submit" class="btn btn-sm btn-success">Salvar</button><br>
            <button type="button" id="btnToogleAll" class="btn btn-sm btn-primary badge-primary mt-2 mb-1">Marcar Todos</button>
            <?php echo $servicesOptions ?>
            <?php form_close() ?>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php echo $this->endSection() ?>


<?php echo $this->section('js') ?>

<?php echo $this->endSection() ?>