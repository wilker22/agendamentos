<?php echo $this->extend('Front/Layout/main'); ?>


<?php echo $this->section('title'); ?>

<?php echo $title ?? 'Home'; ?>

<?php echo $this->endSection(); ?>


<?php echo $this->section('css'); ?>


<?php echo $this->endSection(); ?>


<?php echo $this->section('content'); ?>


<div class="container pt-5">
    <h1 class="mt-5"><?php echo $title; ?></h1>


    <div id="boxSuccess" class="mb-4 mt-3">

    </div>


    <div id="boxErrors" class="mb-4 mt-3">

    </div>


    <div id="boxUserSchedules" class="mb-4 mt-3">


    </div>


</div>


<?php echo $this->endSection(); ?>



<?php echo $this->section('js'); ?>

<script>
    const URL_GET_USER_SCHEDULES = '<?php echo route_to('schedules.my.all'); ?>';
    const URL_CANCEL_USER_SCHEDULES = '<?php echo route_to('schedules.my.cancel'); ?>';

    const boxSuccess = document.getElementById('boxSuccess');
    const boxErrors = document.getElementById('boxErrors');
    const boxUserSchedules = document.getElementById('boxUserSchedules');


    // recupera os agendamentos do user logado
    const getUserSchedules = async () => {


        boxErrors.innerHTML = '';

        const response = await fetch(URL_GET_USER_SCHEDULES, {
            method: "get",
            headers: setHeadersRequest(),
        });

        if (!response.ok) {

            boxErrors.innerHTML = showErrorMessage('Não foi possível recuperar os agendamentos');

            throw new Error(`HTTP error! Status: ${response.status}`);

            return;
        }

        const data = await response.json();

        boxUserSchedules.innerHTML = data.schedules;


        const buttonsCancelSchedule = document.querySelectorAll('.btnCancelSchedule');


        buttonsCancelSchedule.forEach(button => {


            button.addEventListener('click', (event) => {

                const schedule = event.target.dataset.schedule;

                if (!schedule) {

                    boxErrors.innerHTML = showErrorMessage('Não conseguimos identificar o agendamento');
                    return;
                }

                const result = confirm('Tem certeza do cancelamento? \n Essa ação não poderá ser desfeita.');


                if (!result) {

                    return;
                }

                button.disabled = true;

                button.innerText = 'Estamos cancelando o seu agendamento...';

                tryCancelUserSchedule();

            });



        });

    };


    window.addEventListener('load', () => {

        getUserSchedules();
    });
</script>



<?php echo $this->endSection(); ?>