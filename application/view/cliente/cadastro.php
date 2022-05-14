<?php
extract($_REQUEST);
require_once '../../source/banco/conexao.php';
require_once '../../source/php/geral.php';

$id = retorna_somenteNumeros($id);
$acao = $id == false ? 'cadastrar' : 'editar';
$status = 'C';
if ($id == true) {
    $status = 'E';
    $sql = "SELECT * FROM cliente c
        INNER JOIN logradouro l on c.IdLogradouro_Cliente = l.Id_Logradouro  
        INNER JOIN cidade ci on l.IdCidade_Logradouro = ci.Id_Cidade
        WHERE 1 AND Id_Cliente = '$id' AND ISNULL(DataExclusao_Cliente)";

    if ($query = mysqli_query($con, $sql)) {
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_object($query);
        }
    }
}
?>
<form id="cadastroCliente">
    <input type="hidden" name="acao" value="<?php echo $acao; ?>">
    <input type="hidden" name="status" class="status" value="<?php echo $status; ?>">
    <input type="hidden" name="Id_Cliente" value="<?php echo $row->Id_Cliente; ?>">
    <div class="accordion" id="accordionExample">
        <div class="card m-b-0 ">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <a data-toggle="collapse" data-target="#dadosPessoais" aria-expanded="true" aria-controls="dadosPessoais">
                        <i class="m-r-5 mdi mdi-account" aria-hidden="true"></i>
                        <span>Dados Pessoais</span>
                    </a>
                </h5>
            </div>
            <div id="dadosPessoais" class="collapse show borda" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 p-2">
                            <label>Nome</label><br>
                            <input type="text" name="nomeCliente" class="form-control" value="<?php echo $row->Nome_Cliente; ?>" placeholder="Digite o nome do Cliente">
                        </div>
                        <div class="col-md-4 p-2">
                            <label>CPF/CNPJ</label><br>
                            <input type="text" name="documentoCliente" class="form-control cpfcnpj" value="<?php echo $row->CpfCnpj_Cliente; ?>" placeholder="Digite o número do documento">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 p-2">
                            <label>E-mail</label><br>
                            <input type="email" name="emailCliente" class="form-control" value="<?php echo $row->Email_Cliente; ?>" placeholder="Digite o seu e-mail">
                        </div>
                        <div class="col-md-4 p-2">
                            <label>Telefone</label><br>
                            <input type="text" name="telefoneCliente" class="form-control telefone" value="<?php echo $row->Telefone_Cliente; ?>">
                        </div>
                        <div class="col-md-3 p-2">
                            <label>Data Aniversário</label><br>
                            <input type="date" name="dataAniverCliente" class="form-control" value="<?php echo $row->DataNascimento_Cliente; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php

        $IdLogradouro = $row->IdLogradouro_Cliente;
        $cep = $row->Cep_Logradouro;
        $logradouro = $row->Logradouro_Logradouro;
        $num = $row->Numero_Cliente;
        $bairro = $row->Bairro_Logradouro;
        $cidade = $row->Cidade_Cidade;
        $uf = $row->Estado_Cidade;
        include '../form/padrao/endereco.php';

        ?>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-success">Salvar</button>
        </div>
    </div>
</form>

<script>
    mascara_formularios();

    $('#cadastroCliente').submit(function() {
        var form = $("#cadastroCliente").serialize();
        var valStatus = $('.status').val();
        $.ajax({
            url: 'application/controller/cliente.php',
            type: 'POST',
            data: form,
            dataType: "json",
            success: function(data) {
                exibe_alerta(data.status, valStatus);
                fechar_modal();
            }
        });

        return false;
    });
</script>