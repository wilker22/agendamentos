<?php echo $this->extend('Front/Layout/main'); ?>


<?php echo $this->section('title'); ?>

<?php echo $title ?? 'Home'; ?>

<?php echo $this->endSection(); ?>


<?php echo $this->section('css'); ?>


<?php echo $this->endSection(); ?>


<?php echo $this->section('content'); ?>


<div class="container pt-5">
    <h1 class="mt-5"><?php echo $title; ?></h1>


    <div class="row">

        <div class="col-md-12">

            <p class="lead">Escolha uma Unidade</p>

            <?php echo $units; ?>

        </div>

    </div>

</div>


<?php echo $this->endSection(); ?>



<?php echo $this->section('js'); ?>



<?php echo $this->endSection(); ?>