<?php
extract($_REQUEST);
require_once '../source/session/session.php';
require_once '../source/banco/conexao.php';

if ($localidade != '' && $uf != '') {
    $idCidade = 0;
    
    $sql = "SELECT Id_Cidade FROM cidade WHERE 1 AND Cidade_Cidade = '$localidade' AND Estado_Cidade = '$uf'";

    if ($query = mysqli_query($con, $sql)) {
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_object($query);
            $idCidade = $row->Id_Cidade;
        }
    }
    
    if ($idCidade == 0) {
        $inCidade = "INSERT INTO cidade SET Cidade_Cidade = '$localidade', Estado_Cidade = '$uf'";
        if (mysqli_query($con, $inCidade)) $idCidade = mysqli_insert_id($con);
    }

    $inLogradouro = "INSERT INTO logradouro SET Cep_Logradouro = '$cep', Logradouro_Logradouro = '$logradouro', Complemento_Logradouro = '$complemento', Bairro_Logradouro = '$bairro', IdCidade_Logradouro = '$idCidade' ";
    if (mysqli_query($con, $inLogradouro)) {
        $idLogRetorno = mysqli_insert_id($con);
    }
}

echo json_encode(array("idLogradouro" => $idLogRetorno), true);
