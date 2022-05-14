<?php
extract($_REQUEST);
require_once '../../source/session/session.php';
require_once '../../source/banco/conexao.php';

$sql = "SELECT c.Id_Categoria, c.Nome_Categoria, ci.Id_Categoria_Item, ci.IdCategoria_Categoria_Item, ci.Nome_Categoria_Item, ci.Valor_Categoria_Item, cic.Descricao_Categoria_Item_Caracteristica
             FROM categoria c
             INNER JOIN categoria_item ci ON c.Id_Categoria = ci.IdCategoria_Categoria_Item AND ISNULL(c.DataExclusao_Categoria)
             LEFT JOIN categoria_item_caracteristica cic ON ci.Id_Categoria_Item = cic.Id_Categoria_Item_Caracteristica
             WHERE c.Id_Categoria = '$id';";

if ($query = mysqli_query($con, $sql)) {
    if (mysqli_num_rows($query) > 0) {
        $sql = array();
        while ($row = mysqli_fetch_object($query)) {
            $sql[] = $row;
            $html .= '<li class="d-flex no-block card-body p-2 border-top">
                    <div class="col-md-9 d-flex align-items-center">
                        <div class="flex-1 ms-3">
                            <h5 class="mb-0 fw-bold text-1000 ml-3">
                                '.$row->Nome_Categoria_Item.'
                                <i class="mdi mdi-information" data-bs-toggle="tooltip" data-bs-placement="bottom" title="'.$row->Descricao_Categoria_Item_Caracteristica.'"></i>
                            </h5>
                            <span class="mb-0 fw-bold text-1000 ml-3">R$ '.$row->Valor_Categoria_Item.'</span>
                        </div>
                    </div>
                    <div class="col-md-3 p-2 float-right mt-2">
                        <button type="button" class="btn btn-info btn-small" onclick="atualizar_valorPedido(\'' . $row->Valor_Categoria_Item .'\');adiciona_itemPedido(\'' . $row->Id_Categoria_Item . '\', \'' . $row->Nome_Categoria . '\', \'' . $row->Nome_Categoria_Item . '\', \'' . $row->Valor_Categoria_Item . '\')">Adicionar</button>
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
            </ul>
        </div>';

echo json_encode(array("conteudo" => $conteudo), true);