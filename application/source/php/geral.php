<?php
extract($_REQUEST);

function widget_box_open($conteudo){
    $saida = '<div class="widget-box '.$conteudo['Class'].'">
                <div class="widget-title"> <span class="icon"> <i class="'.$conteudo['Icone'].'"></i> </span>
                    <h5>'.$conteudo['Titulo'].'</h5>
                </div>
                <div class="widget-content nopadding tab-content '.$conteudo['Class'].'">';

    return $saida;
}

function widget_box_close(){
    $saida = '</div></div>';
    return $saida;
}

function loading(){
    $saida = '<div class="preloader">
                <div class="lds-ripple">
                    <div class="lds-pos"></div>
                    <div class="lds-pos"></div>
                </div>
            </div>';
    
    return $saida;
}

function data_hora($data){
    $saida = date('d/m/Y H:i', strtotime($data));
    return $saida;
}

function formata_codigo( $codigo ) {
    $saida = str_pad( $codigo, '3', 0, STR_PAD_LEFT );    
    return $saida;
}

function retorna_somenteNumeros( $str ) {
    return preg_replace( '/[^\d]/', '', $str );
}

function forma_pagamento(){
    $sql = "SELECT Id_Forma_Pagamento, Nome_Forma_Pagamento FROM forma_pagamento WHERE isnull(DataExclusao_Forma_Pagamento) AND Nome_Forma_Pagamento != '';";

    if ($query = mysqli_query($_SESSION['Empresa']['con'], $sql)) {
        if (mysqli_num_rows($query) > 0) {
            $sql = array();
            $saida = '<option>Selecione</option>';
            while ($row = mysqli_fetch_object($query)) {
                $saida .= '<option value="'.$row->Id_Forma_Pagamento.'">'.$row->Nome_Forma_Pagamento.'</option>';
            }
        }
    }

    return $saida;
}

function retornarValoresFretes(){
    $saida = '';
    $sql = "SELECT * FROM frete WHERE ISNULL(DataExclusao_Frete) ORDER BY Local_Frete";
    if ($query = mysqli_query($_SESSION['Empresa']['con'], $sql)) {
        if (mysqli_num_rows($query) > 0) {
            $sql = array();
            while ($row = mysqli_fetch_object($query)) {
                $saida .= '<option value="' . $row->Valor_Frete . '">' . $row->Local_Frete . ' - R$ ' . $row->Valor_Frete . '</option>';
            }
        }
    }
    return $saida;
}

function formataMoeda($valor){
    return number_format($valor,2,",",".");
}

function retornaCaminhoImagem($local){
    $caminho = "media/" . md5($_SESSION['banco']->IdCliente_Acesso) .'/'. $local.'/';
    return $caminho;
}

function formata_ValorBanco( $str ) {
    $str = retorna_somenteNumeros( $str );
    
    if( $str == 0 ) $str = '000';
    
    return substr( $str, 0, -2 ).'.'.substr( $str, -2 );
}

function formata_ValorBancoReal( $str ) {
    
    $sinal = substr( trim( $str ), 0, 1 );
    if( $sinal!='-' ) $sinal = '';
    
    $str = retorna_somenteNumeros( $str );
    
    return $sinal . number_format( substr( $str, 0, -2 ).'.'.substr( $str, -2 ), '2', ',', '.' );
}