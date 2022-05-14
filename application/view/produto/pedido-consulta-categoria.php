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
    $conteudo .= '<li class="d-flex no-block card-body p-2 border-top" >
                    <div class="col-md-8 d-flex align-items-center"><img class="img-fluid " width="50px" src="'.$img.'" alt="">
                        <div class="flex-1 ms-3">
                            <h5 class="mb-0 fw-bold text-1000 ml-3">' . $categoria->Nome_Categoria . '</h5>
                        </div>
                    </div>
                    <div class="col-md-4 float-right mt-2">
                        <button type="button" class="btn btn-info btn-small" onclick="pedido_categoria_selecionada(' . $categoria->Id_Categoria . ')">Consulta Item</button>
                    </div>
                </li>';
}

echo json_encode(array("conteudo" => $conteudo), true);
