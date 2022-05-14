<?php
extract($_REQUEST);
require_once '../source/session/session.php';
require_once '../source/banco/conexao.php';
require_once '../source/php/geral.php';

$status = 'error';
if ($acao == 'cadastrar' || $acao == 'editar') {

    $where = '';
    if ($acao == 'cadastrar'){
        $insertUpdate = "INSERT INTO ";
        $where = ", Id_Categoria_Item_Caracteristica = '" . retorna_somenteNumeros($idCaracteristicas) . "'";
    } else if ($acao == 'editar') {
        $insertUpdate = "UPDATE ";
        $where = "WHERE Id_Categoria_Item_Caracteristica = '" . retorna_somenteNumeros($idCaracteristicas) . "' ";
    }

    $inUpCaract =  $insertUpdate . " categoria_item_caracteristica SET Descricao_Categoria_Item_Caracteristica = '$descricaoCaracteristicas'  $where";
    if (mysqli_query($con, $inUpCaract)) $status = 'success';
} 

echo json_encode(array("status" => $status), true);