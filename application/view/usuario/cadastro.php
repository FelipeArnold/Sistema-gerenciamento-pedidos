<?php
extract($_REQUEST);
require_once '../../source/banco/conexao.php';
require_once '../../source/php/geral.php';

$id = retorna_somenteNumeros($id);
$acao = $id == false ? 'cadastrar' : 'editar';
$status = 'C';
if ($id == true) {
    $status = 'E';
    $sql = "SELECT * FROM usuario u
        INNER JOIN logradouro l ON u.IdLogradouro_Usuario = l.Id_Logradouro
        INNER JOIN cidade ci ON l.IdCidade_Logradouro = ci.Id_Cidade
        WHERE 1 AND ISNULL(DataExclusao_Usuario) AND Id_Usuario = '$id' ";

    if ($query = mysqli_query($con, $sql)) {
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_object($query);
        }
    }
}
?>
<form id="cadastroUsuario">
    <input type="hidden" name="acao" value="<?php echo $acao; ?>">
    <input type="hidden" name="status" class="status" value="<?php echo $status; ?>">
    <input type="hidden" name="idusuario" value="<?php echo $row->Id_Usuario; ?>">
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
                            <input type="text" name="nomeUsuario" required class="form-control" value="<?php echo $row->Nome_Usuario; ?>" placeholder="Digite o nome do Usuario">
                        </div>
                        <div class="col-md-4 p-2">
                            <label>CPF</label><br>
                            <input type="text" name="documentoUsuario" required class="form-control cpfcnpj" value="<?php echo $row->Cpf_Usuario; ?>" placeholder="Digite o número do documento">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 p-2">
                            <label>E-mail</label><br>
                            <input type="email" name="emailUsuario" required class="form-control" value="<?php echo $row->Email_Usuario; ?>" placeholder="Digite o seu e-mail">
                        </div>
                        <div class="col-md-3 p-2">
                            <label>Telefone</label><br>
                            <input type="text" name="telefoneUsuario" class="form-control telefone" value="<?php echo $row->Telefone_Usuario; ?>">
                        </div>
                        <div class="col-md-4 p-2">
                            <label>Data Aniversário</label><br>
                            <input type="date" name="dataAniverUsuario" class="form-control" value="<?php echo $row->DataNascimento_Usuario; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 p-2">
                            <label>Tipo Funcionário</label><br>
                            <select class="form-control" name="tipoFuncionario">
                                <option value="Admin" <?php echo $row->Tipo_Usuario == 'Admin' ? 'selected' : ''; ?>>Admin</option>
                                <option value="Funcionario" <?php echo $row->Tipo_Usuario == 'Funcionario' ? 'selected' : ''; ?>>Funcionário</option>
                                <option value="Motoboy" <?php echo $row->Tipo_Usuario == 'Motoboy' ? 'selected' : ''; ?>>Motoboy</option>
                            </select>
                        </div>
                        <div class="col-md-3 p-2 <?php echo $status == 'E' ? 'hide' : ''; ?>">
                            <label>Senha</label><br>
                            <input type="text" name="senhaUsuario" class="form-control" required value="<?php echo $row->Senha_Usuario; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php

        $IdLogradouro = $row->IdLogradouro_Usuario;
        $cep = $row->Cep_Logradouro;
        $logradouro = $row->Logradouro_Logradouro;
        $num = $row->Numero_Usuario;
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

    $('#cadastroUsuario').submit(function() {
        var form = $("#cadastroUsuario").serialize();
        var valStatus = $('.status').val();
        $.ajax({
            url: 'application/controller/usuario.php',
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