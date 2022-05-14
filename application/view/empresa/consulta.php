<?php
extract($_REQUEST);

$arrayFiltro = array("Titulo" => 'Empresa', "Icone" => 'mdi mdi-account', "Class" => 'empresa');

$sql = "SELECT * FROM empresa e
            INNER JOIN logradouro l on l.Id_Logradouro = e.IdLogradouro_Empresa
            INNER JOIN cidade ci on l.IdCidade_Logradouro = ci.Id_Cidade
            LIMIT 1";

if ($query = mysqli_query($con, $sql)) {
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_object($query);
        $status = 'E';
    } else $status = 'C';
}

$acao = $status == 'C' ? 'cadastrar' : 'editar';
/**Busca */
echo widget_box_open($arrayFiltro);
?>
<form id="cadastroEmpresa">
    <input type="hidden" name="acao" value="<?php echo $acao; ?>">
    <input type="hidden" name="status" class="status" value="<?php echo $status; ?>">
    <input type="hidden" name="Id_Empresa" value="<?php echo $row->Id_Empresa; ?>">
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
                    <div class="d-flex">
                        <div class="col-md-4">
                            <label>Nome Empresa</label><br>
                            <input type="text" name="nomeEmpresa" class="form-control" value="<?php echo $row->Nome_Empresa; ?>">
                        </div>
                        <div class="col-md-4">
                            <label>Raz&atilde;o Social</label><br>
                            <input type="text" name="razaoSocial" class="form-control" value="<?php echo $row->RazaoSocial_Empresa; ?>">
                        </div>
                        <div class="col-md-3">
                            <label>E-mail</label><br>
                            <input type="text" name="email" class="form-control" value="<?php echo $row->Email_Empresa; ?>">
                        </div>
                    </div>
                    <div class="mt-3 d-flex">
                        <div class="col-md-6">
                            <label>Respons&aacute;vel da Empresa</label><br>
                            <input type="text" name="responsavelEmpresa" class="form-control" value="<?php echo $row->Responsavel_Empresa; ?>">
                        </div>
                        <div class="col-md-3">
                            <label>CNPJ</label><br>
                            <input type="text" name="cnpjEmpresa" class="form-control" value="<?php echo $row->Cnpj_Empresa; ?>">
                        </div>
                        <div class="col-md-2">
                            <label>Telefone</label><br>
                            <input type="text" name="telefoneEmpresa" class="form-control" value="<?php echo $row->Telefone_Empresa; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <?php

            $IdLogradouro = $row->IdLogradouro_Empresa;
            $cep = $row->Cep_Logradouro;
            $logradouro = $row->Logradouro_Logradouro;
            $bairro = $row->Bairro_Logradouro;
            $cidade = $row->Cidade_Cidade;
            $uf = $row->Estado_Cidade;
            include 'application/view/form/padrao/endereco.php';

            ?>
        </div>

        <div class="col-md-12 text-right mt-2">
            <button type="submit" class="btn btn-success">Salvar</button>
        </div>

    </div>
</form>
<?php echo widget_box_close(); ?>

<script>
    $('#cadastroEmpresa').submit(function() {
        var form = $("#cadastroEmpresa").serialize();
        var valStatus = $('.status').val();
        $.ajax({
            url: 'application/controller/empresa.php',
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