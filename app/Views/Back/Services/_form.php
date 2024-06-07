<div class="row">
    <div class="form-group col-md-12">
        <label for="name">Nome</label>
        <input type="text" class="form-control" name="name" id="name" value="<?php echo old('name', $service->name) ?>" aria-describedby="nameHelp" placeholder="Nome">
        <?php echo show_error_input('name'); ?>
    </div>

    <div class="col-md-12 mb-3 mt-4">
        <div class="custom-control custom-checkbox">
            <?php echo form_hidden('active', '0') ?>
            <input type="checkbox" id="active" value="1" name="active" class="custom-control-input" <?php echo $service->active ? 'checked' : '' ?>>
            <label for="active" class="custom-control-label">Registro Ativo</label>
        </div>
    </div>

</div>

<button type="submit" class="btn btn-primary mt-4">Salvar</button>

<a href="<?php echo base_url(route_to('services')) ?>" class="btn btn-secondary mt-4">Voltar</a>