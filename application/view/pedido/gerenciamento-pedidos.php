<?php extract($_REQUEST); ?>

<div class="border card shadow p-3 mb-5 bg-white rounded">
    <div class="col-md-12 d-flex mb-3">
        <div class="col-md-1">
            <label>Filtrar:</label>
        </div>
        <div class="col-md-2">
            <input type="date" name="dataPedido" id="" value="<?php echo date('Y-m-d'); ?>" class="form-control dataPedido" onblur="buscaPedidoDia()">
        </div>
    </div>

    <div class="col-md-12 d-flex">

        <div class="col-md-3">
            <div class="card shadow p-3 mb-5 bg-white rounded" style="border-left: 3px solid rgb(255 56 71);">
                <div class="card-body text-center">
                    <h4 class="card-title mb-0">Pedido Cancelados</h4>
                </div>
                <ul class="list-style-none">
                    <div class="retornoPedidoCancelado"></div>
                </ul>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow p-3 mb-5 bg-white rounded" style="border-left: 3px solid rgb(232 131 6);">
                <div class="card-body text-center">
                    <h4 class="card-title mb-0">Pedido Solicitado</h4>
                </div>
                <ul class="list-style-none">
                    <div class="retornoPedidoSolicitado"></div>
                </ul>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow p-3 mb-5 bg-white rounded" style="border-left: 3px solid rgb(65 63 158);">
                <div class="card-body text-center">
                    <h4 class="card-title mb-0">Pedido em Andamento</h4>
                </div>
                <ul class="list-style-none">
                    <div class="retornoPedidoAndamento"></div>
                </ul>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow p-3 mb-5 bg-white rounded" style="border-left: 3px solid rgb(2 191 43);">
                <div class="card-body text-center">
                    <h4 class="card-title mb-0">Pedido Finalizados</h4>
                </div>
                <ul class="list-style-none">
                    <div class="retornoPedidoFinalizado"></div>
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="application/source/js/geral.js"></script>
<script>
    consulta_gerenciamentoPedidos('.retornoPedidoCancelado', 'C');
    consulta_gerenciamentoPedidos('.retornoPedidoSolicitado', 'P');
    consulta_gerenciamentoPedidos('.retornoPedidoAndamento', 'A');
    consulta_gerenciamentoPedidos('.retornoPedidoFinalizado', 'F');
</script>