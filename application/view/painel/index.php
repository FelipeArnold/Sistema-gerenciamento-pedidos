<?php

$arrayFiltro = ["Titulo" => 'Relat&oacute;rio Mensal', "Icone" => 'mdi mdi-account', "Class" => 'financeiro'];

$arrayUltimos = [];
$dataMenor = date('Y-m-d', strtotime('-30 days'));
$dataAtual = date('Y-m-d');

for ($i = 0; $i < 15; $i++) {
    $arrayUltimos[date("d/m", strtotime('-' . $i . ' days'))] = ' ';
}

$sqlPedidosultimosDias = "SELECT p.Id_Pedido,DATE(p.DataCadastro_Pedido) dataPedido, p.Status_Pedido, sum(ip.Valor_Itens_Pedido) valorPedidos 
                            FROM pedido p
                            LEFT JOIN itens_pedido ip on ip.IdPedido_Itens_Pedido = p.Id_Pedido
                            WHERE 1 AND DATE(DataCadastro_Pedido) > '$dataMenor' AND DATE(DataCadastro_Pedido) <= '$dataAtual' AND Status_Pedido != 'C'
                            GROUP BY dataPedido
                            ORDER BY dataPedido";

if ($query = mysqli_query($con, $sqlPedidosultimosDias)) {
    if (mysqli_num_rows($query) > 0) {
        $sql = array();
        while ($row = mysqli_fetch_object($query)) {
            $dataCadastro = date('d/m', strtotime($row->dataPedido));
            $arrayUltimos[$dataCadastro] = $row->valorPedidos;
        }
    }
}
?>

<div class="row">
    <!-- Column -->
    <div class="col-md-6 col-lg-2">
        <div class="card card-hover">
            <div class="box bg-cyan text-center">
                <h1 class="font-light text-white">
                    <i class="mdi mdi-view-dashboard"></i>
                </h1>
                <h6 class="text-white">Geren. de Pedidos</h6>
            </div>
        </div>
    </div>
    <!-- Column -->
    <div class="col-md-6 col-lg-2">
        <div class="card card-hover">
            <div class="box bg-success text-center">
                <h1 class="font-light text-white">
                    <i class="mdi mdi-chart-areaspline"></i>
                </h1>
                <h6 class="text-white">Pedido</h6>
            </div>
        </div>
    </div>
    <!-- Column -->
    <div class="col-md-6 col-lg-2">
        <div class="card card-hover">
            <div class="box bg-warning text-center">
                <h1 class="font-light text-white">
                    <i class="mdi mdi-collage"></i>
                </h1>
                <h6 class="text-white">Cliente</h6>
            </div>
        </div>
    </div>
    <!-- Column -->
    <div class="col-md-6 col-lg-2">
        <div class="card card-hover">
            <div class="box bg-danger text-center">
                <h1 class="font-light text-white">
                    <i class="mdi mdi-border-outside"></i>
                </h1>
                <h6 class="text-white">Produto</h6>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-2">
        <div class="card card-hover">
            <div class="box bg-info  text-center">
                <h1 class="font-light text-white">
                    <i class="mdi mdi-border-outside"></i>
                </h1>
                <h6 class="text-white">Perfil</h6>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-2">
        <div class="card card-hover">
            <div class="box bg-dark text-center">
                <h1 class="font-light text-white">
                    <i class="mdi mdi-border-outside"></i>
                </h1>
                <h6 class="text-white">Financeiro</h6>
            </div>
        </div>
    </div>
</div>
<?php

echo widget_box_open($arrayFiltro); ?>

<canvas id="bar-chart-grouped" width="800" height="200"></canvas>
<?php
echo widget_box_close();
/*
echo widget_box_open($arrayFiltro); ?>
<canvas id="pie-chart" width="400" height="150"></canvas>
<?php
echo widget_box_close(); */
?>
<script>
    new Chart(document.getElementById("bar-chart-grouped"), {
        type: 'bar',
        data: {
            labels: [
                <?php
                foreach ($arrayUltimos as $key => $mes) {
                    echo "'" . $key . "',";
                }
                ?>
            ],
            datasets: [{
                label: "Valor Total",
                backgroundColor: "#5bb75b",
                data: [
                    <?php
                    foreach ($arrayUltimos as $key => $mes) {
                        echo "'" . $arrayUltimos[$key] . "',";
                    }
                    ?>
                ]
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Vendas nos últimos 30 dias'
            }
        }
    });

    new Chart(document.getElementById("pie-chart"), {
        type: 'pie',
        data: {
            labels: ["Aplicativo", "Site"],
            datasets: [{
                label: "Population (millions)",
                backgroundColor: ["#5bb75b", "#49afcd"],
                data: [2478, 5267]
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Local das Vistorias do mês de setembro'
            }
        }
    });
</script>