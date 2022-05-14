<?php
//criar pastas de imagens padrao
$caminhoImagem = "media/" . md5($_SESSION['banco']->IdCliente_Acesso);
mkdir($caminhoImagem);
mkdir($caminhoImagem. '/categoria');
mkdir($caminhoImagem. '/empresa');
mkdir($caminhoImagem. '/usuario');