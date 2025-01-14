<?php echo $this->extend('Front/Layout/main'); ?>

<?php echo $this->section('title') ?>
<?php echo $title ?? 'Home'; ?>
<?php echo $this->endSection() ?>

<?php echo $this->section('css') ?>
<style>
    /** para deixar o botão do dia um pouco menor */
    .btn-calendar-day {
        max-width: 36px !important;
        min-width: 36px !important;
        line-height: 0px !important;
        padding: 10% !important;
        height: 30px !important;
        display: table-cell !important;
        vertical-align: middle !important;
    }

    .btn-calendar-day-chosen {
        color: #fff !important;
        background-color: #28a745 !important;
        border-color: #28a745 !important;
    }

    .btn-hour {
        margin-bottom: 10px !important;
        max-width: 55px !important;
        min-width: 55px !important;
        padding-left: 8px !important;
        line-height: 0px !important;
        height: 30px !important;
    }

    .btn-hour-chosen {
        color: #fff !important;
        background-color: #28a745 !important;
        border-color: #28a745 !important;
    }


    /** para centralizar o conteúdo dentro da célula do calendário */
    td {
        text-align: center;
        vertical-align: middle;
    }

    /** para aparecer os options dos dropdowns */
    .wizard .content .form-control {
        padding: .375rem 0.75rem !important;
    }
</style>
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
    const URL_GET_CALENDAR = '<?php echo route_to('get.calendar'); ?>';
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

    //mês
    document.getElementById('month').addEventListener('change', (event) => {
        chosenMonthText.innerText = '';

        /** @todo criar essa funçao
         * resetBoxCalendar = '';
         */
        const month = event.target.value;
        if (!month) {
            /** @todo criar função
             * resetMonth */

            //resetMonthDataVariables();
            //resetBoxCalendar();

            return;
        }

        //mês valido escolhido...

        //atribuimos a variavel de escopo global o valor do mês escolhido
        chosenMonth = event.target.value;
        chosenMonthText.innerText = event.target.options[event.target.selectedIndex].text;
        getCalendar(chosenMonth);

    });

    const getCalendar = async () => {
    //limpar erros
    boxErrors.innerHTML = '';
    chosenDayText.innerText = '';
    chosenHourText.innerText = '';

    let url = URL_GET_CALENDAR + '?' + setParameters({

        month: month
    });

    const response = await fetch(url, {
        method: 'get',
        headers: setHeadersRequest()
    });

    if (!response.ok) {
        boxErrors.innerHTML = showErrorMessage('Não foi possível recuperar o Calendário!');
        throw new Error(`HTTP error! Status: ${response.status}`);
        return;
    }

    const data = await response.json();

    });
</script>

<?php echo $this->endSection() ?>