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

        <div class="col-md-8">

            <div class="row">

                <!-- unidades -->
                <div class="col-md-12 mb-4">

                    <p class="lead">Escolha uma Unidade</p>

                    <?php echo $units; ?>

                </div>

                <!-- Serviços da unidade (oculto no load da view)-->
                <div id="mainBoxServices" class="col-md-12 d-none mb-4">

                    <p class="lead">Escolha o Serviço</p>

                    <div id="boxServices">


                    </div>

                </div>


            </div>

        </div>

        <!-- Preview do que for sendo escolhido-->
        <div class="col-md-2 ms-auto">

            <p class="lead mt-4">Unidade escolhida: <br><span id="chosenUnitText" class="text-muted small"></span></p>
            <p class="lead">Serviço escolhido: <br><span id="chosenServiceText" class="text-muted small"></span></p>
            <p class="lead">Mês escolhido: <br><span id="chosenMonthText" class="text-muted small"></span></p>
            <p class="lead">Dia escolhido: <br><span id="chosenDayText" class="text-muted small"></span></p>
            <p class="lead">Horário escolhido: <br><span id="chosenHourText" class="text-muted small"></span></p>

        </div>

    </div>

</div>


<?php echo $this->endSection(); ?>



<?php echo $this->section('js'); ?>

<script>
    const URL_GET_SERVICES = '<?php echo route_to('get.unit.services'); ?>';
</script>

<?php echo $this->endSection(); ?>