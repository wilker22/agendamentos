<?php echo $this->extend('Front/Layout/main'); ?>

<?php echo $this->section('title') ?>
<?php echo $title ?? 'Home'; ?>
<?php echo $this->endSection() ?>

<?php echo $this->section('css') ?>

<?php echo $this->endSection() ?>


<?php echo $this->section('content') ?>
<div class="container pt-5 text-center">
    <h1 class="mt-5">Realize seus Agendamentos:</h1>

    <div class="row mt-4">
        <div class="col">
            <div class="card">
                <div class="card-header">Primeiro</div>
                <div class="card-body">
                    <h5 class="card-title">
                        Faça o Login!
                    </h5>
                    <p>Realize o login ou crie sua conta.</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-header">Segundo</div>
                <div class="card-body">
                    <h5 class="card-title">
                        Escolha a Unidade
                    </h5>
                    <p>onde você gostaria de ser atendida(o).</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-header">Terceiro</div>
                <div class="card-body">
                    <h5 class="card-title">
                        Escolha qual Serviço
                    </h5>
                    <p>que deseja atendimento!</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-header">Quarto</div>
                <div class="card-body">
                    <h5 class="card-title">
                        Quando?
                    </h5>
                    <p>Escolha a data e horário.</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-header">Confirmação</div>
                <div class="card-body">
                    <h5 class="card-title">
                        Revise seus dados
                    </h5>
                    <p>E confirme o agendamento</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <a href="<?php echo base_url(route_to('schedules.new')) ?>" class="btn btn-lg btn-primary">Agendar</a>
        </div>
    </div>

</div>



<?php echo $this->endSection() ?>


<?php echo $this->section('js') ?>

<?php echo $this->endSection() ?>