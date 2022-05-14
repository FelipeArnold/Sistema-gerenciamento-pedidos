<?php
extract($_REQUEST);

require_once '../../source/session/session.php';
require_once '../../source/banco/conexao.php';
require_once '../../source/php/geral.php';

$sql = "SELECT * FROM categoria_item WHERE 1 AND IdCategoria_Categoria_Item = '$id' AND ISNULL(DataExclusao_Categoria_Item)";

if ($query = mysqli_query($con, $sql)) {
    if (mysqli_num_rows($query) > 0) {
        $sql = array();
        while ($row = mysqli_fetch_object($query)) {
            $sql[] = $row;
            $html .= '<li class="d-flex no-block card-body p-2 border-top">
                    <div class="col-md-11 d-flex align-items-center">
                        <div class="flex-1 ms-3" onclick="consulta_caracteristicas_item('.$row->Id_Categoria_Item.')">
                            <h5 class="mb-0 fw-bold text-1000 ml-3">'.$row->Nome_Categoria_Item.'</h5>
                            <span class="mb-0 fw-bold text-1000 ml-3">R$ '.formata_ValorBancoReal($row->Valor_Categoria_Item).'</span>
                        </div>
                    </div>
                    <div class="col-md-1 float-right">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></button>
                                <div class="dropdown-menu p-2" aria-labelledby="btnGroupDrop1">
                                    <a class="dropdown-item" href="#" onclick="modal_cadastro(\'Cadastro de Itens da Categoria\', \'categoria/categoria-item\', ' . $row->Id_Categoria_Item . ')" data-toggle="modal" data-target="#modalConteudo"><i class="mdi mdi-table-edit mr-2"></i>Editar</a>
                                    <a class="dropdown-item" href="#" onclick="exibeExclusao(' . $row->Id_Categoria_Item . ', \'categoria-item\')"><i class="mdi mdi-delete-forever mr-2"></i>Excluir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>';
        }
    }
}


$conteudo = '<div class="card shadow p-3 mb-5 bg-white rounded">
            <div class="card-body text-center">
                <h4 class="card-title mb-0">Itens</h4>
            </div>
            <ul class="list-style-none ">
                ' . $html . '
                <li class="no-block card-body p-3 border-top text-center">
                    <div class="btn btn-outline-success btn-small text-center btn-block" onclick="modal_cadastro(\'Cadastro de Itens da Categoria\', \'categoria/categoria-item\', '.$id.')" data-toggle="modal" data-target="#modalConteudo"><span><i class="mdi mdi-plus"></i> ADICIONAR ITEM</span> </div>
                </li>
            </ul>
        </div>';

echo json_encode(array("conteudo" => $conteudo), true);