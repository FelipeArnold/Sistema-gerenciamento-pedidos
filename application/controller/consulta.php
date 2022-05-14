<?php
extract($_REQUEST);
require_once '../source/session/session.php';
require_once '../source/banco/conexao.php';
require_once '../source/php/geral.php';

if ($acao == 'cliente') {
    $sql = "SELECT Id_Cliente, Nome_Cliente, Telefone_Cliente, Numero_Cliente, Cep_Logradouro, Logradouro_Logradouro, Bairro_Logradouro, Cidade_Cidade, Estado_Cidade
            FROM cliente  c
            INNER JOIN logradouro l on c.IdLogradouro_Cliente = l.Id_Logradouro
            INNER JOIN cidade ci on ci.Id_Cidade = l.IdCidade_Logradouro
            WHERE isnull(DataExclusao_Cliente) AND Nome_Cliente LIKE ('%$filtro%') OR Telefone_Cliente LIKE ('%$filtro%');";
}

$conteudo = '<ul class="list-unstyled bg-white">';

if ($query = mysqli_query($_SESSION['Empresa']['con'], $sql)) {
    if (mysqli_num_rows($query) > 0) {
        $sql = array();
        while ($row = mysqli_fetch_object($query)) {
            $html = '';
            $endereco = $row->Logradouro_Logradouro . ' , ' . $row->Numero_Cliente . ' | ' . $row->Bairro_Logradouro . ' | ' . $row->Cidade_Cidade . '/' . $row->Estado_Cidade;
            if ($acao == 'cliente') {
                $html = '<div class="col-md-12"><strong>Nome: </strong> ' . $row->Nome_Cliente . '</b> - <span>' . $row->Telefone_Cliente . '</span></div>
                         <div class="col-md-12"><strong>Endereço:</strong>' . $endereco . ' </div>';

                $onclick = "retorno_consulta($row->Id_Cliente, '" . $row->Nome_Cliente . "', '" . $row->Telefone_Cliente . "', '" . $endereco . "', 'cliente')";
                $conteudo .= '<li class="p-2 border-bottom" onclick="' . $onclick . '"> ' . $html . '</li>';
            }
        }
    } else $conteudo .= '<li class="p-2"><b>Nenhum registro encontrado</b></li>';
}

$conteudo .= '</ul>';

echo json_encode(array("conteudo" => $conteudo), true);
