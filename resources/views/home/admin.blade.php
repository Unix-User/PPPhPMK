@extends('layouts.default')

@section('title' , 'Inicio')

@push('styles')
<link rel="stylesheet" href=" {{ mix('css/style.css')}} " />
@endpush


@section('content')
<header class="major">
    <h2>Bem vindo <span class="text-capitalize"><?php echo $this->auth->name() ?></span></h2>
    <p>Informações administrativas</p>
</header>
<!-- Content -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#perfil" role="tab" aria-controls="profile" aria-selected="false">Perfil</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages" role="tab" aria-controls="messages" aria-selected="false">Mensagens</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Configurações</a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div id="piechart" style="width: 900px; height: 500px;"></div>
    </div>
    <div class="tab-pane" id="perfil" role="tabpanel" aria-labelledby="profile-tab">...2</div>
    <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">...3</div>
    <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">...4</div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Recebido', 500],
            ['Inadimplente', 1100]
        ]);

        var options = {
            title: 'Relatrio de faturamento'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
</script>
<script>
    $(function() {
        $('#myTab li:last-child a').tab('show')
    })
</script>
@endsection