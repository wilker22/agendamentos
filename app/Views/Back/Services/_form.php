<div class="row">

    <div class="form-group col-md-12">
        <label for="name">Nome</label>
        <input type="text" class="form-control" name="name" value="<?php echo old('name', $service->name); ?>" id="name" aria-describedby="nameHelp" placeholder="Nome">
        <?php echo show_error_input('name'); ?>
    </div>


    <div class="col-md-12 mb-3 mt-4">

        <div class="custom-control custom-checkbox">
            <?php echo form_hidden('active', 0); ?>
            <input type="checkbox" name="active" value="1" <?php if ($service->active) : ?> checked <?php endif; ?> class="custom-control-input" id="active">
            <label class="custom-control-label" for="active">Registro ativo</label>

        </div>

    </div>

</div>


<button type="submit" class="btn btn-primary mt-4">Salvar</button>

<a href="<?php echo route_to('services') ?>" class="btn btn-secondary mt-4">Voltar</a>