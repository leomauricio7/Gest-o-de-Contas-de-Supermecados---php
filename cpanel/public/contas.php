<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page">Início</li>
        <li class="breadcrumb-item active" aria-current="page">Dividas Cadastradas</li>
    </ol>
</nav>
<?php
    if ($_POST) {
            $dados = Validation::limpaDados(filter_input_array(INPUT_POST, FILTER_DEFAULT));
            $user = new Conta();
            $user->createConta($dados);
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
<!-- ALTERTS PAGAMENTOS-->

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

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Contas Cadastrados</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button class=" btn btn-sm btn-dark" data-toggle="modal" data-target="#create-conta"><i class="fa fa-plus-circle"></i> Nova Divida</button>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Status</th>
                <th>Data para pagamento</th>
                <th>valor</th>
                <th>Ultimo pagamento</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            $read= new Read();
            $read->getContas();
            foreach($read->getResult() as $dados){
                extract($dados);
            ?>
            <tr>
                <td><?php echo $id; ?></td>
                <td><?php echo $cliente; ?></td>
                <td><span class="badge badge-<?php echo validation::getStatus($id_status) ?>"> <?php echo $status; ?></span></td>
                <td><?php echo date('d/m/Y', strtotime($data_para_pagamento)) ?></td>
                <td>R$ <?php echo number_format($valor, 2, ',', ''); ?></td>
                <td><?php echo $ultimo_pagamento ?  date('d/m/Y', strtotime($ultimo_pagamento)) : '-' ; ?></td>
                <td>
                    <?php if($valor != '0.00'){ ?>
                    <button alt="<?php echo $id ?>" class="btn btn-sm btn-info pagar-parcialmente" data-toggle="tooltip" data-placement="top" title="Paga apenas um valor da divida."> <span class="fa fa-edit"></span> Pagar Parcialmente</button>
                    <button alt="<?php echo $id ?>" class="btn btn-sm btn-success pagar-completamente" data-toggle="tooltip" data-placement="top" title="Paga a divida completamente"> <span class="fa fa-edit"></span> Pagar Completamente</button>
                    <?php } ?>
                    <a data-toggle="tooltip" data-placement="top" title="Excluir Divida" href="<?php echo Url::getBase() . './app/delete.php?pag=contas&tb=contas&ch=id&value=' . $id; ?>" class="btn btn-sm btn-danger"> <span class="fa fa-trash"></span> Excluir</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<!-- Modal de cadastro -->
<div class="modal fade" id="create-conta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nova Divida</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="form-conta">
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Cliente</label>
                <div class="col-sm-10">
                    <select class="form-control" name="id_cliente" required>
                        <option value="">--SELECIONE--</option>
                        <?php 
                            $read = new Read();
                            $read->ExeRead('clientes');
                            foreach($read->getResult() as $dados){
                                extract($dados);
                        ?>
                        <option value="<?php echo $id ?>"><?php echo $nome ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Status Conta</label>
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
                <label for="inputPassword" class="col-sm-2 col-form-label">Valor da Divida</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="valor" required>
                    <small id="passwordHelpBlock" class="form-text text-muted">
                        Digite o valor da divida separado por <strong>.</strong> e não por <strong>,</strong> Ex: 5.90 e não 5,90
                    </small>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Data para pagamento</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="data_para_pagamento" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Divida</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        
      </div>
    </div>
  </div>
</div>
