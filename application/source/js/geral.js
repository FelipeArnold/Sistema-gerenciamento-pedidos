$('#meuModal').on('shown.bs.modal', function () {
    $('#meuInput').trigger('focus')
})

function modal_cadastro(titulo, url, id = false) {
    $('#modalConteudo .conteudo-modal').html('');
    $('#modalTitulo').html(titulo);
    var conteudo = '';
    if (id != false) {
        console.log('teste')
        conteudo = 'id=' + id;
    }
    $.ajax({
        url: 'application/view/' + url + '.php',
        type: 'POST',
        data: conteudo,
        success: function (data) {
            $('.conteudo-modal').html(data)
        }
    });
}

function exibe_alertaLogin(status) {

    var titulo = texto = '';
    if (status == 'error') {
        titulo = 'Dados invalidos. Tente novamente.';
    } else titulo = 'Bem Vindo ao Sistema';

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: status,
        title: titulo,
    })
}

function exibe_alerta(status, situacao) {
    /**Situacao
     * D = Excluido
     * C = Cadastrado
     * E = Editado
     */
    var titulo = texto = '';
    if (situacao == 'C') {
        if (status == 'error') {
            titulo = 'Erro!';
            texto = 'Erro ao cadastrar';
        } else if (status == 'success') {
            titulo = 'Sucesso!';
            texto = 'Cadastro realizado com sucesso!';
        }
    } else if (situacao == 'E') {
        if (status == 'error') {
            titulo = 'Erro!';
            texto = 'Erro ao editar cadastrar';
        } else if (status == 'success') {
            titulo = 'Sucesso!';
            texto = 'Cadastro editado com sucesso!';
        }
    } else {
        if (status == 'error') {
            titulo = 'Erro!';
            texto = 'Erro ao excluir cadastrar';
        } else if (status == 'success') {
            titulo = 'Sucesso!';
            texto = 'Cadastro excluido com sucesso!';
        }
    }
    if (status == 'success') toastr.success(texto, titulo);
    else if (status == 'error') toastr.error(texto, titulo);

    toastr.options = {
        "closeButton": true,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
}

function fechar_modal() {
    $('#modalTitulo, .conteudo-modal').html('');
    $('.close').click();
}

function consulta_endereco(cep) {
    var cepNum = cep.replace(/\D/gim, '');
    $.getJSON("https://viacep.com.br/ws/" + cepNum + "/json/?callback=?", function (dados) {
        $.ajax({
            url: 'application/controller/endereco.php',
            type: 'POST',
            data: dados,
            dataType: "json",
            success: function (data) {
                $('.idLogradouro').val(data.idLogradouro);
                $('.logradouro').val(dados.logradouro);
                $('.bairro').val(dados.bairro);
                $('.cidade').val(dados.localidade);
                $('.uf').val(dados.uf);
                $('.numero').removeAttr('disabled');
            }
        });
    });
}

function mascara_formularios() {
    $('.date').mask('00/00/0000');
    $('.time').mask('00:00:00');
    $('.date_time').mask('00/00/0000 00:00:00');
    $('.cep').mask('00000-000');
    $('.phone').mask('0000-0000');
    $('.telefone').mask('(00) 0000-0000');
    $('.phone_us').mask('(000) 000-0000');
    $('.mixed').mask('AAA 000-S0S');
    $('.cpf').mask('000.000.000-00', {
        reverse: true
    });
    $('.cnpj').mask('00.000.000/0000-00', {
        reverse: true
    });
    $('.money').mask('000.000.000.000.000,00', {
        reverse: true
    });
    $('.money2').mask("#.##0,00", {
        reverse: true
    });
    $('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
        translation: {
            'Z': {
                pattern: /[0-9]/,
                optional: true
            }
        }
    });
    $('.ip_address').mask('099.099.099.099');
    $('.percent').mask('##0,00%', {
        reverse: true
    });
    $('.clear-if-not-match').mask("00/00/0000", {
        clearIfNotMatch: true
    });
    $('.placeholder').mask("00/00/0000", {
        placeholder: "__/__/____"
    });
    $('.fallback').mask("00r00r0000", {
        translation: {
            'r': {
                pattern: /[\/]/,
                fallback: '/'
            },
            placeholder: "__/__/____"
        }
    });
    $('.selectonfocus').mask("00/00/0000", {
        selectOnFocus: true
    });
}


function lista_consulta(conteudo, acao) {
    var filtro = conteudo.value;
    $('.consulta_lista_' + acao + ' .retorno_lista_consulta').html('<ul class="list-unstyled bg-white"><li class="p-2 text-center"> <span class="text-success"> <i class="fas fa-spinner fa-spin mr-2"></i>Carregando...</span></li></ul>');
    $.ajax({
        url: 'application/controller/consulta.php',
        type: 'POST',
        data: 'acao=' + acao + '&filtro=' + filtro,
        dataType: "json",
        success: function (data) {
            $('.consulta_lista_' + acao + ' .retorno_lista_consulta').html(data.conteudo);
        }
    });

}

function retorno_consulta(id, nome, telefone, endereco, chave) {
    if (chave == 'cliente') {
        $('.idCliente').val(id);
        $('.nomeCliente').val(nome);
        resumo_adiciona_cliente(nome, telefone, endereco)
    }
    $('.retorno_lista_consulta').remove();
}

function resumo_adiciona_cliente(nome, telefone, endereco) {
    $('.resumo_nomeCliente').html(nome);
    $('.resumo_telefoneCliente').html(telefone);
    $('.resumo_enderecoCliente').html(endereco).show();
}

function consulta_categoria() {
    $.ajax({
        url: 'application/view/produto/consulta-categoria.php',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            $('.retornoCategoria').html(data.conteudo);
        }
    });
}

function pedido_consulta_categoria() {
    $.ajax({
        url: 'application/view/produto/pedido-consulta-categoria.php',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            $('.retornoCategoria').html(data.conteudo);
        }
    });
}

function categoria_selecionada(id) {
    $.ajax({
        url: 'application/view/produto/consulta-categoriaItem.php',
        type: 'POST',
        data: 'id=' + id,
        dataType: 'json',
        success: function (data) {
            $('.retornoCategoriaItem').html(data.conteudo);
        }
    });
}

function pedido_categoria_selecionada(id) {
    $.ajax({
        url: 'application/view/produto/pedido-consulta-categoriaItem.php',
        type: 'POST',
        data: 'id=' + id,
        dataType: 'json',
        success: function (data) {
            $('.retornoCategoriaItem').html(data.conteudo);
        }
    });
}

function consulta_gerenciamentoPedidos(local, status) {
    $(local).html('<li class="p-2 text-center"> <span class="text-success"> <i class="fas fa-spinner fa-spin mr-2"></i>Carregando...</span></li>');
    var dataPedido = $('.dataPedido').val();
    $.ajax({
        url: 'application/view/pedido/consulta-gerenciamentoPedidos.php',
        type: 'POST',
        data: 'status=' + status +'&dataPedido=' + dataPedido,
        dataType: 'json',
        success: function (data) {
            $(local).html(data.conteudo);
        }
    });
}

function montaResumo(icone, title, conteudo) {
    Swal.fire({
        icon: icone,
        background: '#fff',
        allowOutsideClick: false,
        showConfirmButton: false,
        showCloseButton: true,
        title: title,
        html: conteudo,
    });
}

function consultaResumo(idPedido) {
    $.ajax({
        url: 'application/view/pedido/resumoPedido.php',
        type: 'POST',
        data: 'idPedido=' + idPedido,
        dataType: 'json',
        success: function (data) {
            montaResumo(data.icone, 'Código do Pedido: #' + data.codigo, data.conteudo);
        }
    });
}

function exibeExclusao(id, uri) {
    Swal.fire({
        title: 'Deseja realmente excluir?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28b779',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Excluir'
    }).then((result) => {
        if (result.isConfirmed) {
            exclusaoCadastro(id, uri);
        }
    })
}

function exclusaoCadastro(id, uri) {
    if (id != '') {
        $.ajax({
            url: 'application/controller/' + uri + '.php',
            type: 'POST',
            data: 'acao=excluir&idExclusao=' + id,
            dataType: 'json',
            success: function (data) {
                exibe_alerta(data.status, data.msg);
                if (uri == 'categoria') consulta_categoria();
            }
        });
    }
}


function alteraStatusPedido(id, status) {
    Swal.fire({
        title: 'Deseja alterar esse status?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28b779',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Alterar'
    }).then((result) => {
        if (result.isConfirmed) {
            alteraStatus(id, status);
        }
    })
}

function alteraStatus(id, status) {
    if (id != '') {
        $.ajax({
            url: 'application/controller/pedido-status.php',
            type: 'POST',
            data: 'acao=alteraStatus&idPedido=' + id + '&statusPedido=' + status,
            dataType: 'json',
            success: function (data) {
                exibe_alerta(data.status, 'E');
                consulta_gerenciamentoPedidos('.retornoPedidoCancelado', 'C');
                consulta_gerenciamentoPedidos('.retornoPedidoSolicitado', 'P');
                consulta_gerenciamentoPedidos('.retornoPedidoAndamento', 'A');
                consulta_gerenciamentoPedidos('.retornoPedidoFinalizado', 'F');
            }
        });
    }
}

function buscaPedidoDia() {
    consulta_gerenciamentoPedidos('.retornoPedidoCancelado', 'C');
    consulta_gerenciamentoPedidos('.retornoPedidoSolicitado', 'P');
    consulta_gerenciamentoPedidos('.retornoPedidoAndamento', 'A');
    consulta_gerenciamentoPedidos('.retornoPedidoFinalizado', 'F');
}