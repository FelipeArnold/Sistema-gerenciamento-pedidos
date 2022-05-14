<?php
extract($_REQUEST);

require_once '../../source/banco/conexaoLogin.php';
//echo sha1('felipearnold.94@gmail.com-chave-acesso-Kn01Qt01');

$valida = 0;
if (!empty($emailLogin) && !empty($passwordLogin)) {
    $senha = sha1($passwordLogin);

    $sql = "SELECT * FROM cliente 
            WHERE Email_Cliente = '$emailLogin' AND Senha_Cliente = '$senha';";

    if ($query = mysqli_query($conControle, $sql)) {
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_object($query);

            if ($row->Id_Cliente) {

                $sqlAcesso = "SELECT * FROM acesso WHERE IdCliente_Acesso = $row->Id_Cliente LIMIT 1";
                if ($queryAcesso = mysqli_query($conControle, $sqlAcesso)) {
                    if (mysqli_num_rows($queryAcesso) > 0) {
                        $rowAcesso = mysqli_fetch_object($queryAcesso);
                        $valida = 1;
                        session_start();
                        $_SESSION['banco'] = $rowAcesso;
                        $_SESSION['chaveAcesso'] = $row->ChaveAcesso_Cliente;
                        
                    }
                }
            }
        }
    }
}

echo json_encode($valida);
exit;
