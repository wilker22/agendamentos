<?php echo $this->extend('Back/Layout/main'); ?>


<?php echo $this->section('title'); ?>

<?php echo $title ?? 'Home'; ?>

<?php echo $this->endSection(); ?>


<?php echo $this->section('css'); ?>

<?php echo $this->endSection(); ?>


<?php echo $this->section('content'); ?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo $title; ?></h6>
        </div>
        <div class="card-body">

            <?php echo form_open(route_to('units.update', $unit->id), hidden: ['_method' => 'PUT']); ?>

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" class="form-control" name="name" value="<?php echo old('name', $unit->name); ?>" id="name" aria-describedby="nameHelp" placeholder="Nome">
            </div>

            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>

            <?php echo form_close(); ?>

        </div>
    </div>

</div>
<!-- /.container-fluid -->


<?php echo $this->endSection(); ?>



<?php echo $this->section('js'); ?>


<?php echo $this->endSection(); ?>