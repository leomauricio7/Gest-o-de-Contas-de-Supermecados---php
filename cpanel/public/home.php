<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Página Inicial </li>
    </ol>
</nav>
<div class="row" id="print">  
    <div class="col-4 text-center">
        <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
            <div class="card-header"><i class="fa fa-users"></i> Clientes
                <h5 class="card-title"><?php echo validation::getSTotaldados('clientes');  ?></h5>
            </div>
        </div>
        <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
            <div class="card-header"><i class="fa fa-shopping-cart"></i> Dividas
                <h5 class="card-title"><?php echo validation::getSTotaldados('contas');  ?></h5>
            </div>
        </div>
        <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
            <div class="card-header"><i class="fa fa-user"></i> Usuários
                <h5 class="card-title"><?php echo validation::getSTotaldados('usuarios');  ?></h5>
            </div>
        </div>
    </div>

    <div class="col-8">
      <div id="piechart_3d" style="width: 100%; height: 500px;"></div>
    </div>
</div>
<!-- Graphs -->
<script src="<?php echo Url::getBase() . '../js/chart.min.js'; ?>"></script>
<script type="text/javascript">
    google.charts.load("current", {packages: ["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Aguardando Pagamento', <?php echo Validation::getStatusDividas(1) ?>],
            ['Paga', <?php echo Validation::getStatusDividas(2) ?>],
            ['Atrasada', <?php echo Validation::getStatusDividas(3) ?>],
            ['Paga Parcialmente', <?php echo Validation::getStatusDividas(4) ?>]
        ]);

        var options = {
            title: 'Status das dividas',
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
    }
</script>
