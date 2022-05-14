<?php
extract($_REQUEST);

require_once '../../source/session/session.php';
require_once '../../source/banco/conexao.php';
require_once '../../source/php/geral.php';

$sql = "SELECT * FROM categoria WHERE 1 AND ISNULL(DataExclusao_Categoria)";

if ($query = mysqli_query($con, $sql)) {
    if (mysqli_num_rows($query) > 0) {
        $sql = array();
        while ($row = mysqli_fetch_object($query)) {
            $sql[] = $row;
        }
    }
}

$conteudo = '';
foreach ($sql as $categoria) {

    $caminho = retornaCaminhoImagem('categoria');
    $img = '';
    $img = $categoria->Icone_Categoria ? $caminho. $categoria->Icone_Categoria : 'assets/images/background/icone.png';

    $conteudo .= '<li class="d-flex no-block card-body p-2 border-top">
                    <div class="col-md-11 d-flex align-items-center"  onclick="categoria_selecionada(' . $categoria->Id_Categoria . ')">
                        <img class="img-fluid " width="50px" src="'.$img.'" alt="">
                        <div class="flex-1 ms-3">
                            <h5 class="mb-0 fw-bold text-1000 ml-3">' . $categoria->Nome_Categoria . '</h5>
                        </div>
                    </div>
                    <div class="col-md-1 float-right">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></button>
                                <div class="dropdown-menu p-2" aria-labelledby="btnGroupDrop1">
                                    <a class="dropdown-item" href="#" onclick="modal_cadastro(\'Cadastro de Categoria\', \'categoria/cadastro\', ' . $categoria->Id_Categoria . ')" data-toggle="modal" data-target="#modalConteudo"><i class="mdi mdi-table-edit mr-2"></i>Editar</a>
                                    <a class="dropdown-item" href="#" onclick="exibeExclusao(' . $categoria->Id_Categoria . ', \'categoria\')"><i class="mdi mdi-delete-forever mr-2"></i>Excluir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>';
}

echo json_encode(array("conteudo" => $conteudo), true);
