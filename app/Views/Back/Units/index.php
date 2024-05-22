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
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Início</th>
                            <th>Fim </th>
                            <th>Criado</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($units as $unit) : ?>
                            <tr>
                                <td><?php echo $unit->name ?></td>
                                <td><?php echo $unit->email ?></td>
                                <td><?php echo $unit->phone ?></td>
                                <td><?php echo $unit->starttime ?></td>
                                <td><?php echo $unit->endtime ?></td>
                                <td><?php echo $unit->created_at ?></td>
                            </tr>
                        <?php endforeach ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php echo $this->endSection() ?>


<?php echo $this->section('js') ?>

<?php echo $this->endSection() ?>