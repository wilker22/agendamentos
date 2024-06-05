<div class="row">
    <div class="form-group col-md-4">
        <label for="name">Nome</label>
        <input type="text" class="form-control" name="name" id="name" value="<?php echo old('name', $unit->name) ?>" aria-describedby="nameHelp" placeholder="Nome">
        <?php echo show_error_input('name'); ?>
    </div>

    <div class="form-group col-md-4">
        <label for="phone">Telefone</label>
        <input type="text" class="form-control" name="phone" id="phone" value="<?php echo old('phone', $unit->phone) ?>" aria-describedby="nameHelp" placeholder="Telefone">
        <?php echo show_error_input('phone'); ?>
    </div>

    <div class="form-group col-md-4">
        <label for="coordinator">Gerente</label>
        <input type="text" class="form-control" name="coordinator" id="coodinator" value="<?php echo old('coordinator', $unit->coordinator) ?>" aria-describedby="coordinatorHelp" placeholder="Gerente">
        <?php echo show_error_input('coordinator'); ?>
    </div>

    <div class="form-group col-md-4">
        <label for="starttime">Abertura da Unidade</label>
        <input type="time" class="form-control" name="starttime" id="starttime" value="<?php echo old('starttime', $unit->starttime) ?>" aria-describedby="nameHelp" placeholder="Abertura">
        <?php echo show_error_input('starttime'); ?>
    </div>

    <div class="form-group col-md-4">
        <label for="endtime">Fechamento da Unidade</label>
        <input type="time" class="form-control" name="endtime" id="endtime" value="<?php echo old('endtime', $unit->endtime) ?>" aria-describedby="nameHelp" placeholder="Fechamento">
        <?php echo show_error_input('endtime'); ?>
    </div>

    <div class="form-group col-md-4">
        <label for="servicetime">Tempo de cada atendimento</label>
        <?php echo $timesInterval ?>
        <?php echo show_error_input('servicetime'); ?>
    </div>

    <div class="form-group col-md-4">
        <label for="email">E-mail</label>
        <input type="email" class="form-control" name="email" id="email" value="<?php echo old('email', $unit->email) ?>" aria-describedby="coordinatorHelp" placeholder="E-mail">
        <?php echo show_error_input('email'); ?>
    </div>

    <div class="form-group col-md-4">
        <label for="address">Endereço</label>
        <input type="text" class="form-control" name="address" id="address" value="<?php echo old('address', $unit->address) ?>" aria-describedby="addressHelp" placeholder="endereço">
        <?php echo show_error_input('address'); ?>
    </div>

    <div class="col-md-12 mb-3 mt-4">
        <div class="custom-control custom-checkbox">
            <?php echo form_hidden('active', 0) ?>
            <input type="checkbox" id="active" value="1" name="active" class="custom-control-input" <?php echo $unit->active ? 'checked' : '' ?>>
            <label for="active" class="custom-control-label">Registro Ativo</label>
        </div>
    </div>

</div>

<button type="submit" class="btn btn-primary mt-4">Salvar</button>

<a href="<?php echo base_url(route_to('units')) ?>" class="btn btn-secondary mt-4">Voltar</a>