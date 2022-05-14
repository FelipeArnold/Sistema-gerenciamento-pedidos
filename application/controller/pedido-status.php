<?php
extract($_REQUEST);
require_once '../source/session/session.php';
require_once '../source/banco/conexao.php';
require_once '../source/php/geral.php';

$status = 'error';

if($acao == 'alteraStatus' && !empty($idPedido)){
    $StatusPedido = "UPDATE pedido SET Status_Pedido = '$statusPedido' WHERE Id_Pedido = '".retorna_somenteNumeros($idPedido)."'";
    if (mysqli_query($con, $StatusPedido)) $status = 'success';
}

echo json_encode(array("status" => $status), true);
exit;