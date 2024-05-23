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
            <h6 class="m-0 font-weight-bold text-primary"><?php echo $title; ?></h6>

        </div>
        <div class="card-body">
            <?php echo form_open(route_to('units.update', $unit->id), hidden: ['_method' => 'PUT']) ?>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="name">Nome</label>
                    <input type="text" class="form-control" name="name" id="name" value="<?php echo old('name', $unit->name) ?>" aria-describedby="nameHelp" placeholder="Nome">
                </div>

                <div class="form-group col-md-4">
                    <label for="phone">Telefone</label>
                    <input type="text" class="form-control" name="phone" id="phone" value="<?php echo old('phone', $unit->phone) ?>" aria-describedby="nameHelp" placeholder="Telefone">
                </div>

                <div class="form-group col-md-4">
                    <label for="coordinator">Gerente</label>
                    <input type="text" class="form-control" name="coordinator" id="coodinator" value="<?php echo old('coordinator', $unit->coordinator) ?>" aria-describedby="coordinatorHelp" placeholder="Gerente">
                </div>

                <div class="form-group col-md-4">
                    <label for="starttime">Abertura da Unidade</label>
                    <input type="time" class="form-control" name="starttime" id="starttime" value="<?php echo old('starttime', $unit->starttime) ?>" aria-describedby="nameHelp" placeholder="Abertura">
                </div>

                <div class="form-group col-md-4">
                    <label for="endtime">Fechamento da Unidade</label>
                    <input type="time" class="form-control" name="endtime" id="endtime" value="<?php echo old('endtime', $unit->endtime) ?>" aria-describedby="nameHelp" placeholder="Fechamento">
                </div>

                <div class="form-group col-md-4">
                    <label for="servicetime">Duração do Serviço</label>
                    <input type="time" class="form-control" name="servicetime" id="servicetime" value="<?php echo old('endtime', $unit->servicetime) ?>" aria-describedby="nameHelp" placeholder="Duração do Serviço">
                </div>

                <div class="form-group col-md-4">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" name="email" id="email" value="<?php echo old('email', $unit->email) ?>" aria-describedby="coordinatorHelp" placeholder="E-mail">
                </div>

                <div class="form-group col-md-4">
                    <label for="address">Endereço</label>
                    <input type="text" class="form-control" name="address" id="address" value="<?php echo old('address', $unit->address) ?>" aria-describedby="addressHelp" placeholder="endereço">
                </div>

                <div class="col-md-12 mb-3 mt-4">
                    <div class="custom-controll custom-checkbox">
                        <input type="checkbox" name="active" class="custom-control-input" checked>
                        <label for="active" class="custom-control-label">Registro Ativo</label>
                    </div>
                </div>

            </div>

            <button type="submit" class="btn btn-primary">Submit</button>

            <?php echo form_close() ?>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php echo $this->endSection() ?>


<?php echo $this->section('js') ?>

<?php echo $this->endSection() ?>