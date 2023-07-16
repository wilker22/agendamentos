<?php echo $this->extend('Front/Layout/main'); ?>


<?php echo $this->section('title'); ?>

<?php echo $title ?? 'Home'; ?>

<?php echo $this->endSection(); ?>


<?php echo $this->section('css'); ?>


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


<?php echo $this->endSection(); ?>


<?php echo $this->section('content'); ?>


<div class="container pt-5">
    <h1 class="mt-5"><?php echo $title; ?></h1>

    <div id="boxErrors" class="mt-4 mb-3">

    </div>

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


                <!-- Mês (oculto no load da view)-->
                <div id="boxMonths" class="col-md-12 d-none mb-4">

                    <p class="lead">Escolha o Mês</p>

                    <?php echo $months; ?>

                </div>


                <div id="mainBoxCalendar" class="col-md-12 d-none mb-4">

                    <p class="lead">Escolha o dia e o horário</p>

                    <div class="row">

                        <div class="col-md-6 form-group">

                            <div id="boxCalendar">

                            </div>

                        </div>

                        <div class="col-md-6 form-group">

                            <div id="boxHours">

                            </div>

                        </div>

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
    const URL_GET_CALENDAR = '<?php echo route_to('get.calendar'); ?>';
    const URL_GET_HOURS = '<?php echo route_to('get.hours'); ?>';

    const boxErrors = document.getElementById('boxErrors');

    const mainBoxServices = document.getElementById('mainBoxServices');
    const boxServices = document.getElementById('boxServices');
    const boxMonths = document.getElementById('boxMonths');
    const mainBoxCalendar = document.getElementById('mainBoxCalendar');
    const boxCalendar = document.getElementById('boxCalendar');
    const boxHours = document.getElementById('boxHours');

    // preview do que está sendo escolhido
    const chosenUnitText = document.getElementById('chosenUnitText');
    const chosenServiceText = document.getElementById('chosenServiceText');
    const chosenMonthText = document.getElementById('chosenMonthText');
    const chosenDayText = document.getElementById('chosenDayText');
    const chosenHourText = document.getElementById('chosenHourText');




    // variáveis de escopo global que utilizaremos na criação do agendamento
    let unitId = null;
    let serviceId = null;
    let chosenMonth = null;
    let chosenDay = null;
    let chosenHour = null;


    const units = document.getElementsByName('unit_id');

    units.forEach(element => {

        // adicionar para cada elemento um 'listener' ou ouvinte
        element.addEventListener('click', (event) => {

            mainBoxServices.classList.remove('d-none');

            // atribuo à variável global o valor da unidade clicada
            unitId = element.value;

            if (!unitId) {

                alert('Erro ao determinar a Unidade escolhida');
                return;
            }

            chosenUnitText.innerText = element.getAttribute('data-unit');
            chosenServiceText.innerText = '';
            chosenMonthText.innerText = '';
            chosenDayText.innerText = '';
            chosenHourText.innerText = '';


            getServices();

        });


    });


    // recupera os serviços da unidade
    const getServices = async () => {

        //BOX ERRORS CRIAR DEPOIS
        boxErrors.innerHTML = '';

        let url = URL_GET_SERVICES + '?' + setParameters({
            unit_id: unitId
        });


        const response = await fetch(url, {
            method: 'get',
            headers: setHeadersRequest()
        });


        if (!response.ok) {

            boxErrors.innerHTML = showErrorMessage('Não foi possível recuperar os Serviços');

            throw new Error(`HTTP error! Status: ${response.status}`);

            return;
        }



        const data = await response.json();

        // colocamos na div os serviços devolvidos no response
        boxServices.innerHTML = data.services;

        const elementService = document.getElementById('service_id');

        elementService.addEventListener('change', (event) => {

            serviceId = elementService.value ?? null;
            let serviceName = serviceId !== '' ? elementService.options[event.target.selectedIndex].text : null;

            console.log('Serviço foi escolhido? ', serviceId !== '');

            chosenServiceText.innerText = serviceName;

            serviceId !== '' ? boxMonths.classList.remove('d-none') : boxMonths.classList.add('d-none');

        });

    };


    // mês
    document.getElementById('month').addEventListener('change', (event) => {


        // limpo o preview do mês escolhido a cada mudança
        chosenMonthText.innerText = '';

        /**
         * @todo CRIAR ESSA FUNÇÃO
         */
        // resetBoxCalendar();

        const month = event.target.value;

        if (!month) {

            /**
             * @todo CRIAR FUNÇÃO
             */
            // resetMonthDataVariables();

            // resetBoxCalendar();

            return;
        }

        // mês válido escolhido...

        // atribuímos à variável de escopo global o valor do mês escolhido
        chosenMonth = event.target.value;

        chosenMonthText.innerText = event.target.options[event.target.selectedIndex].text;

        // finalmente buscamos o calendário para mês escolhido
        getCalendar();

    });

    // calendário
    const getCalendar = async () => {

        //limpo os erros
        boxErrors.innerHTML = '';

        // limpo o preview do dia e da hora escolhidos, pois o user precisará clicar no horário novamente
        chosenDayText.innerText = '';
        chosenHourText.innerText = '';

        let url = URL_GET_CALENDAR + '?' + setParameters({
            month: chosenMonth
        });

        const response = await fetch(url, {
            method: 'get',
            headers: setHeadersRequest(),
        });

        if (!response.ok) {

            boxErrors.innerHTML = showErrorMessage('Não foi possível recuperar o calendário para o mês informado');

            throw new Error(`HTTP error! Status: ${response.status}`);

            return;
        }

        // recuperamos a resposta
        const data = await response.json();

        // exibo a div do calendário e das horas
        mainBoxCalendar.classList.remove('d-none');

        // colamos na div o calendário criado
        boxCalendar.innerHTML = data.calendar;


        // agora recupero os elementos que tenham a classe '.chosenDay', 
        // ou seja os dias que são buttons
        const buttonsChosenDay = document.querySelectorAll('.chosenDay');


        // percorro todos os botões
        buttonsChosenDay.forEach(element => {

            // e fico 'escutando' o click no elemento
            // e para cada click recupero o valor de 'data-day'
            element.addEventListener('click', (event) => {


                // limpo o preview da hora
                chosenDayText.innerText = '';


                // redefino para null para garantir
                chosenHour = null;

                /**
                 * @todo criar função para remover a classe do botões clicados
                 */

                event.target.classList.add('btn-calendar-day-chosen');


                // armazeno na variável global
                chosenDay = event.target.dataset.day;


                // dia escolhido no preview
                chosenDayText.innerText = chosenDay;


                getHours();

            });


        });

    }


    const getHours = async () => {


        boxErrors.innerHTML = '';


        // a unidade realmente foi escolhida?
        if (!unitId) {

            boxErrors.innerHTML = showErrorMessage('Você precisa escolher a Unidade de atendimento');
            return;
        }

        let url = URL_GET_HOURS + '?' + setParameters({
            unit_id: unitId,
            month: chosenMonth,
            day: chosenDay
        });


        const response = await fetch(url, {
            method: 'get',
            headers: setHeadersRequest(),
        });

        if (!response.ok) {

            boxErrors.innerHTML = showErrorMessage('Não foi possível recuperar os horários disponíveis');

            throw new Error(`HTTP error! Status: ${response.status}`);

            return;
        }

        // recuperamos a resposta
        const data = await response.json();


        // recupero as horas
        const hours = data.hours;


        if (hours === null) {

            boxHours.innerHTML = showErrorMessage(`Não há horários disponíveis para o dia ${chosenDay}`);

            chosenDay = null;

            return;
        }


        // colocamos na div as horas
        boxHours.innerHTML = hours;



    };
</script>

<?php echo $this->endSection(); ?>