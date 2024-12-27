<?php echo $this->extend('Front/Layout/main'); ?>

<?php echo $this->section('title') ?>
<?php echo $title ?? 'Home'; ?>
<?php echo $this->endSection() ?>

<?php echo $this->section('css') ?>

<?php echo $this->endSection() ?>


<?php echo $this->section('content') ?>
<div class="container pt-5 text-center">
    <h1 class="mt-5"><?php echo $title; ?></h1>

    <div id="boxErrors" class="mt-4 mb-3">

    </div>


    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <!--unidades-->
                <div class="col-md-12 mb-4">

                    <p class="lead">Escolha uma Unidade:</p>

                    <?php echo $units; ?>
                </div>

                <!-- serviços -->
                <div id="mainBoxServices" class="col-md-12 d-none mb-4">
                    <p class="lead">
                        Escolha o serviço:
                    </p>
                    <div id="boxServices">

                    </div>
                </div>


                <div id="boxMonths" class="col-md-12 d-none mb-4">
                    <p class="lead">
                        Escolha o Mês:
                        <?php echo $months; ?>
                    </p>

                </div>
            </div>
        </div>
        <!-- preview da escolha -->
        <div class="col-md-2 ms-auto">
            <p class="lead mt-4">Unidade: <br><span id="chosenUnitText" class="text-muted  small"></span></p>
            <p class="lead ">Serviço: <br><span id="chosenServiceText" class="text-muted  small"></span></p>
            <p class="lead ">Mês: <br><span id="chosenMonthText" class="text-muted  small"></span></p>
            <p class="lead ">Dia: <br><span id="chosenDayText" class="text-muted  small"></span></p>
            <p class="lead ">Horário: <br><span id="chosenHourText" class="text-muted  small"></span></p>
        </div>
    </div>

</div>



<?php echo $this->endSection() ?>


<?php echo $this->section('js') ?>

<script>
    const URL_GET_SERVICES = '<?php echo route_to('get.unit.services'); ?>';
    const boxErrors = document.getElementById('boxErrors');
    const mainBoxServices = document.getElementById('mainBoxServices');
    const boxServices = document.getElementById('boxServices');
    const boxMonths = document.getElementById('boxMonths');
    const chosenUnitText = document.getElementById('chosenUnitText');
    const chosenServiceText = document.getElementById('chosenServiceText');
    const chosenMonthText = document.getElementById('chosenMonthText');
    const chosenDayText = document.getElementById('chosenDayText');
    const chosenHourText = document.getElementById('chosenHourText');


    //variaveis globais para criação do agendamento
    let UnitId = null;
    let serviceId = null;
    let chosenMonth = null;
    let chosenDay = null;
    let chosenHour = null;

    const units = document.getElementsByName('unit_id');

    units.forEach(element => {
        //adicionar para cada elemento um listener
        element.addEventListener('click', (event) => {
            mainBoxServices.classList.remove('d-none');
            unitId = element.value;

            if (!unitId) {
                alert('Erro !');
                return;
            }

            chosenUnitText.innerText = element.getAttribute('data-unit');
            chosenServiceText.innerText = '';
            chosenServiceText.innerText = '';
            chosenMonthText.innerText = '';
            chosenDayText.innerText = '';
            chosenHourText.innerText = '';

            getServices();
        })
    });

    const getServices = async () => {

        //BOX ERRORS
        boxErrors.innerHTML = '';

        let url = URL_GET_SERVICES + '?' + setParameters({
            unit_id: unitId
        });

        const response = await fetch(url, {
            method: 'get',
            headers: setHeadersRequest()
        });

        if (!response.ok) {
            boxErrors.innerHTML = showErrorMessage('Não foi possível recuperar os Serviços!');
            throw new Error(`HTTP error! Status: ${response.status}`);
            return;
        }

        const data = await response.json();

        boxServices.innerHTML = data.services;

        const elementService = document.getElementById('service_id');
        elementService.addEventListener('change', (event) => {
            serviceId = elementService.value ?? null;
            let serviceName = serviceId !== '' ? elementService.options[event.target.selectedIndex].text : null;

            console.log('Serviço escolhido?', serviceId !== '');
            chosenServiceText.innerText = serviceName;

            serviceId !== '' ? boxMonths.classList.remove('d-none') : boxMonths.classList.add('d-none');
        });
    };
</script>

<?php echo $this->endSection() ?>