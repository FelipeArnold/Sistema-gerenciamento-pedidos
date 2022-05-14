<?php
extract($_REQUEST);
require_once '../source/session/session.php';
require_once '../source/banco/conexao.php';
require_once '../source/php/geral.php';

$status = 'error';
if ($acao == 'cadastrar' || $acao == 'editar') {

   if (is_uploaded_file($_FILES['imagem']['tmp_name'])) {
      $caminhoImagem = "../../media/" . md5($_SESSION['banco']->IdCliente_Acesso) . '/categoria';
      $extensao = explode('/', $_FILES['imagem']['type']);
      $nomeArquivo = md5(time(). $nomeCategoria) . '.' . $extensao[1];

      // Essa função move_uploaded_file() copia e verifica se o arquivo enviado foi copiado com sucesso para o destino  
      if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem . '/' . $nomeArquivo)) {
         $retorno = array('status' => 0, 'mensagem' => 'Houve um erro ao gravar arquivo na pasta de destino!');
         echo json_encode($retorno);
         exit();
      }
   }
   
   $where = '';
   if ($acao == 'cadastrar') $insertUpdate = "INSERT INTO ";
   else if ($acao == 'editar') {
      $insertUpdate = "UPDATE ";
      $where = "WHERE Id_Categoria = '" . retorna_somenteNumeros($idCategoria) . "' ";
   }

   $inUpCliente =  $insertUpdate  . " categoria SET Nome_Categoria = '$nomeCategoria', Icone_Categoria = '$nomeArquivo'
                $where";

   if (mysqli_query($con, $inUpCliente)) $status = 'success';
} else if ($acao == 'excluir' && !empty((int)$idExclusao)) {
   $dataExclusao = date('Y-d-m H:i');
   $excluirCliente = "UPDATE categoria SET DataExclusao_Categoria = '$dataExclusao' WHERE Id_Categoria = '" . retorna_somenteNumeros($idExclusao) . "'";
   if (mysqli_query($con, $excluirCliente)) $status = 'success';
}

echo json_encode(array("status" => $status), true);
