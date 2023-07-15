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

            <div class="row">

                <div class="form-group col-md-4">
                    <label for="name">Nome</label>
                    <input type="text" class="form-control" name="name" value="<?php echo old('name', $unit->name); ?>" id="name" aria-describedby="nameHelp" placeholder="Nome">
                </div>


                <div class="form-group col-md-4">
                    <label for="phone">Telefone</label>
                    <input type="tel" class="form-control" name="phone" value="<?php echo old('phone', $unit->phone); ?>" id="phone" aria-describedby="phoneHelp" placeholder="Telefone">
                </div>

                <div class="form-group col-md-4">
                    <label for="coordinator">Telefone</label>
                    <input type="text" class="form-control" name="coordinator" value="<?php echo old('coordinator', $unit->coordinator); ?>" id="coordinator" aria-describedby="coordinatorHelp" placeholder="Coordenador">
                </div>

                <div class="form-group col-md-4">
                    <label for="starttime">Início expediente</label>
                    <input type="time" class="form-control" name="starttime" value="<?php echo old('starttime', $unit->starttime); ?>" id="starttime" aria-describedby="starttimeHelp" placeholder="Início expediente">
                </div>

                <div class="form-group col-md-4">
                    <label for="endtime">Final expediente</label>
                    <input type="time" class="form-control" name="endtime" value="<?php echo old('endtime', $unit->endtime); ?>" id="endtime" aria-describedby="endtimeHelp" placeholder="Final expediente">
                </div>


                <div class="form-group col-md-4">
                    <label for="servicetime">Tempo de cada atendimento</label>

                    <?php echo $timesInterval; ?>
                </div>


                <div class="form-group col-md-4">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" name="email" value="<?php echo old('email', $unit->email); ?>" id="email" aria-describedby="emailHelp" placeholder="E-mail">
                </div>


                <div class="form-group col-md-4">
                    <label for="address">Endereço</label>
                    <input type="text" class="form-control" name="address" value="<?php echo old('address', $unit->address); ?>" id="address" aria-describedby="addressHelp" placeholder="Endereço">
                </div>


                <div class="col-md-12 mb-3 mt-4">

                    <div class="custom-control custom-checkbox">
                        <?php echo form_hidden('active', 0); ?>
                        <input type="checkbox" name="active" value="1" <?php if ($unit->active) : ?> checked <?php endif; ?> class="custom-control-input" id="active">
                        <label class="custom-control-label" for="active">Registro ativo</label>

                    </div>

                </div>

            </div>


            <button type="submit" class="btn btn-primary mt-4">Salvar</button>

            <?php echo form_close(); ?>

        </div>
    </div>

</div>
<!-- /.container-fluid -->


<?php echo $this->endSection(); ?>



<?php echo $this->section('js'); ?>


<?php echo $this->endSection(); ?>