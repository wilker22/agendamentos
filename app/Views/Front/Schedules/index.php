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



    <div class="row">

        <div class="col-md-8">

            <div class="mt-3">

                <?php if (session()->has('success')) : ?>

                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo session('success'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                <?php endif; ?>


            </div>

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


                <div id="boxErrors" class="mt-4 mb-3">

                </div>
                <div class="col-md-12 border-top pt-4">

                    <button id="btnTryCreate" class="btn btn-primary">Criar meu agendamento</button>

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
    const URL_CREATION_SCHEDULE = '<?php echo route_to('create.schedule'); ?>';

    const boxErrors = document.getElementById('boxErrors');

    const mainBoxServices = document.getElementById('mainBoxServices');
    const boxServices = document.getElementById('boxServices');
    const boxMonths = document.getElementById('boxMonths');
    const mainBoxCalendar = document.getElementById('mainBoxCalendar');
    const boxCalendar = document.getElementById('boxCalendar');
    const boxHours = document.getElementById('boxHours');
    const btnTryCreate = document.getElementById('btnTryCreate');

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

            // redefinimos as opções dos meses
            resetMonthOptions();


            // redefino o calendário
            resetBoxCalendar();

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

        resetBoxCalendar();

        const month = event.target.value;

        if (!month) {


            resetMonthDataVariables();

            resetBoxCalendar();

            return;
        }

        // mês válido escolhido...

        // atribuímos à variável de escopo global o valor do mês escolhido
        chosenMonth = event.target.value;

        chosenMonthText.innerText = event.target.options[event.target.selectedIndex].text;

        // finalmente buscamos o calendário para mês escolhido
        getCalendar();

    });


    btnTryCreate.addEventListener('click', (event) => {


        event.preventDefault();


        boxErrors.innerHTML = '';

        // unidade foi escolhida?
        if (unitId === null || unitId === '') {

            boxErrors.innerHTML = showErrorMessage('Escolha a Unidade');
            return;
        }


        // serviço foi escolhido?
        if (serviceId === null || serviceId === '') {

            boxErrors.innerHTML = showErrorMessage('Escolha o Serviço');
            return;
        }

        // verificamos se os campos referente ao mês, dia e hora estão devidamente preenchidos
        const dateFieldsAreFilled = (chosenMonth !== null && chosenDay !== null && chosenHour !== null);


        if (!dateFieldsAreFilled) {

            boxErrors.innerHTML = showErrorMessage('Escolha o Mês, Dia e hora para prosseguir');
            return;
        }

        // desabilitamos o botão
        btnTryCreate.disabled = true;
        btnTryCreate.innerText = 'Estamos criando o seu agendamento...';

        // agora podemos criar o agendamento
        tryCreateSchedule();

    });


    //--------------------FUNÇÕES--------------------------//

    // tenta criar o agendamento
    const tryCreateSchedule = async () => {

        boxErrors.innerHTML = '';

        // o que será enviado no request
        const body = {
            unit_id: unitId,
            serviceId: serviceId,
            month: chosenMonth,
            day: chosenDay,
            hour: chosenHour
        };


        const response = await fetch(URL_CREATION_SCHEDULE, {
            method: 'post',
            headers: setHeadersRequest(),
            body: JSON.stringify(body)
        });

        if (!response.ok) {

            // temos erros de validação (status code = 400)?
            if (response.status === 400) {

                // habilito o botão para nova tentativa
                btnTryCreate.disabled = false;
                btnTryCreate.innerText = 'Criar meu agendamento';

                const data = await response.json();
                const errors = data.errors;

                // tranformo o array de erros em uma string
                let message = Object.keys(errors).map(field => errors[field]).join(', ');

                boxErrors.innerHTML = showErrorMessage(message);

                return;
            }

            // erro diferente de 400

            boxErrors.innerHTML = showErrorMessage('Não foi possível criar o seu agendamento');

            throw new Error(`HTTP error! Status: ${response.status}`);

            return;
        }


        // tudo certo... agendamento criado

        // retornamos para a mesma view para exibir a mensagem de successo.
        window.location.href = window.location.href;
    };

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
                chosenHourText.innerText = '';

                // mensagem
                boxHours.innerHTML = '<span class="text-info">Carregando as horas...</span>';


                // redefino para null para garantir
                chosenHour = null;


                // antes precisamos remover
                removeClassFromElements(buttonsChosenDay, 'btn-calendar-day-chosen');

                // adiciona a classe no elemento
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


        // agora recupero os elementos que tenham a classe '.btn-hour',
        // ou seja, os buttons dos horários
        const buttonsBtnHour = document.querySelectorAll('.btn-hour');


        // percorro eles
        buttonsBtnHour.forEach(element => {

            element.addEventListener('click', (event) => {


                // removo a classe antes
                removeClassFromElements(buttonsBtnHour, 'btn-hour-chosen');

                // e agora adiciono só no elemento clicado
                event.target.classList.add('btn-hour-chosen');

                // armazenamos na variável global
                chosenHour = event.target.dataset.hour;


                // preview da hora escolhida
                chosenHourText.innerText = chosenHour;
            });
        });



    };


    // redefine as opções dos meses
    const resetMonthOptions = () => {

        console.log('Redefini as opções de meses...');

        // ocultamos a div dos meses
        boxMonths.classList.add('d-none');


        // volta para a opção '--- Escolha ---'
        document.getElementById('month').selectedIndex = 0;

        // nulamos esses campos
        resetMonthDataVariables();
    }


    // Redefine as variáveis pertinentes ao mês, dia, hora
    const resetMonthDataVariables = () => {

        console.log('Redefini as variáveis pertinentes ao mês, dia, hora...');

        chosenMonth = null;
        chosenDay = null;
        chosenHour = null;
    }


    // Redefine o calendário
    const resetBoxCalendar = () => {

        console.log('Redefini o calendário...');

        mainBoxCalendar.classList.add('d-none');


        boxCalendar.innerHTML = '';
        boxHours.innerHTML = '';

    }


    // remove a classe do array de elementos
    const removeClassFromElements = (elements, className) => {

        elements.forEach(element => {

            if (element.classList.contains(className)) {

                element.classList.remove(className);
            }
        });
    };
</script>

<?php echo $this->endSection(); ?>