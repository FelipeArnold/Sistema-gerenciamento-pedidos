<?php
extract($_REQUEST);

require_once '../../source/session/session.php';
require_once '../../source/banco/conexao.php';
require_once '../../source/php/geral.php';

$sql = "SELECT p.Id_Pedido, DATE(p.DataCadastro_Pedido) DataCadastro_Pedido, p.Tipo_Pedido, p.Status_Pedido, c.Id_Cliente, c.Nome_Cliente, c.IdLogradouro_Cliente, c.Numero_Cliente, l.Cep_Logradouro, l.Logradouro_Logradouro,
                l.Complemento_Logradouro, ci.Cidade_Cidade, ci.Estado_Cidade
        FROM pedido p
        INNER JOIN cliente c ON p.IdCliente_Pedido = c.Id_Cliente
        LEFT JOIN logradouro l ON l.Id_Logradouro = c.IdLogradouro_Cliente
        LEFT JOIN cidade ci ON ci.Id_Cidade = l.IdCidade_Logradouro
        WHERE 1 AND Status_Pedido = '$status' AND DATE(DataCadastro_Pedido) = '$dataPedido' ";

if ($query = mysqli_query($con, $sql)) {
    if (mysqli_num_rows($query) > 0) {
        $sql = array();
        while ($row = mysqli_fetch_object($query)) {
            $endereco = $row->Logradouro_Logradouro . ', ' . $row->Numero_Cliente . ' - ' . $row->Cep_Logradouro;
            $tipoPedido = $row->Tipo_Pedido == 'E' ? 'Entrega' : 'Retirada';
            $conteudo .= '<li class="no-block card-body p-2 border-top">
                <div class="d-flex">
                <div class="col-md-8 d-flex align-items-center">
                    <div class="flex-1">
                        <strong class="mr-3">#' . formata_codigo($row->Id_Pedido) . '</strong>
                        <strong>' . $tipoPedido . '</strong>
                    </div>
                </div>
                <div class="col-md-4 mt-2">
                    <button type="button" class="btn btn-light btn-small p-2 float-right" style="display: contents" onclick="consultaResumo(\'' . $row->Id_Pedido . '\')"><i class="mdi mdi-eye"></i></button>
                    <div class="btn-group float-right" style="display: contents" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-outline-dark btn-small border-0 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></button>
                            <div class="dropdown-menu p-2" aria-labelledby="btnGroupDrop1">
                                <a class="dropdown-item" href="#" onclick="alteraStatusPedido(' . $row->Id_Pedido . ', \'A\')"><i class="mdi mdi-alert-circle-outline text-info mr-2"></i>Andamento</a>
                                <a class="dropdown-item" href="#" onclick="alteraStatusPedido(' . $row->Id_Pedido . ', \'C\')"><i class="mdi mdi-delete-forever text-danger mr-2"></i>Cancelado</a>
                                <a class="dropdown-item" href="#" onclick="alteraStatusPedido(' . $row->Id_Pedido . ', \'F\')"><i class="mdi mdi-check-circle-outline text-success mr-2"></i>Finalizado</a>
                                <a class="dropdown-item" href="#" onclick="alteraStatusPedido(' . $row->Id_Pedido . ', \'P\')"><i class="mdi mdi-alert text-warning mr-2"></i>Solicitado</a>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="col-md-12 ">
                    <h6 class="mb-0 fw-bold text-1000">' . $row->Nome_Cliente . '</h6>
                    <span>' . $endereco . '</span>
                </div>
            </li>';
        }
    } else {
        $conteudo .= '<li class="card-body p-2 border-top">
                        <div class="swal2-validation-message" id="swal2-validation-message" style="display: table-cell;">Está finalização está vazia.</div>
                    </li>';
    }
}

echo json_encode(array("status" => $status, "conteudo" => $conteudo), true);
