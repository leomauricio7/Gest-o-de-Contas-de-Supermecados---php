<?php 
if(!Url::getURL(1)){
    require_once '404.php';
}else{ ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page">Início</li>
        <li class="breadcrumb-item" aria-current="page">Conta</li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo Validation::getClienteCompra(Url::getURL(1)) ?></li>
    </ol>
</nav>
<?php
    if ($_POST) {
            $dados = Validation::limpaDados(filter_input_array(INPUT_POST, FILTER_DEFAULT));
            $dados['valor_atual'] = $dados['valor'];
            $user = new Compra();
            $user->createCompra($dados);
            if (!$user->getResult()):
                echo $user->getMsg();
                unset($_POST); 
            else:
                echo $user->getMsg();
                unset($_POST); 
            endif;
            unset($_POST);   
    }
?>
<div class="alert alert-success alert-dismissible fade show" role="alert" id="success" style="display:none">
  <strong>Atenção</strong> Divida paga com sucesso.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<div class="alert alert-danger alert-dismissible fade show" role="alert" id="error" style="display:none">
  <strong>Atenção</strong> Error no processamento do pagamento.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="row">
<div class="col">
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Compras</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button class=" btn btn-sm btn-dark" data-toggle="modal" data-target="#create-compra"><i class="fa fa-plus-circle"></i> Nova Compra</button>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-sm table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col" title="Data da compra">Data</th>
                <th scope="col" title="Valor da compra">Valor</th>
                <th scope="col" title="Valor do que falta ser pago dessa compra">Dívida</th>
                <th scope="col" title="Data do ultimo pagamento">DUP</th>
                <th scope="col" title="Valor do ultimo pagamento">VUP</th>
                <th scope="col">Situação</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $read = new Read();
        $read->getCompras('WHERE c.id_conta = '.Url::getURL(1));
        foreach($read->getResult() as $compras){
            extract($compras);
        ?>
            <tr>
                <td><?php echo $id_compra; ?></td>
                <td><?php echo date('d/m/Y', strtotime($created)) ?></td>
                <td>R$ <?php echo number_format($valor, 2, ',', ''); ?></td>
                <td><?php echo number_format($valor_atual, 2, ',', ''); ?></td>
                <td><?php echo date('d/m/Y', strtotime($updated)); ?></td>
                <td>R$ <?php echo number_format($valor_ultimo_pagamento, 2, ',', ''); ?></td>
                <td><span class="badge badge-<?php echo validation::getStatus($id_status) ?>"> <?php echo $status; ?></span></td>
                <td>
                    <?php if($valor_atual != '0.00'){ ?>
                    <button alt="<?php echo $id_compra ?>" class="btn btn-sm btn-info pagar-parcialmente" data-toggle="tooltip" data-placement="top" title="Paga apenas um valor da divida."> <span class="fa fa-edit"></span> Pagamento</button>
                    <?php } ?>
                   <a data-toggle="tooltip" data-placement="top" title="Excluir compra" href="<?php echo Url::getBase() . './app/delete.php?pag=compras/'.URL::getURL(1).'&tb=compras&ch=id&value=' . $id_compra; ?>" class="btn btn-sm btn-danger"> <span class="fa fa-trash"></span> Excluir</a>
                </td>
            </tr>
        <?php } ?>
        <tr>
        <td cols=""></td>
        </tr>
        </tbody>
    </table>
    </div>
</div>
</div>
<!-- Modal de cadastro de compra-->
<div class="modal fade" id="create-compra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nova Compra</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="form-conta">
            <div class="form-group row">
            <input type="hidden" name="id_conta" value="<?php echo Url::getURL(1) ?>">
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Situação</label>
                <div class="col-sm-10">
                    <select class="form-control" name="id_status" required>
                    <option value="">--SELECIONE--</option>
                        <?php 
                            $read = new Read();
                            $read->ExeRead('status_compra');
                            foreach($read->getResult() as $dados){
                                extract($dados);
                        ?>
                        <option value="<?php echo $id ?>"><?php echo $status ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Valor</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="valor" required>
                    <small id="passwordHelpBlock" class="form-text text-muted">
                        Digite o valor da divida separado por <strong>.</strong> e não por <strong>,</strong> Ex: 5.90 e não 5,90
                    </small>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Finalizar Compra</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php } ?>