<?php if($_SESSION['idTipo'] == 1){?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Relatórios </li>
    </ol>
</nav>
<div class="row" id="rel">
    <div class="col">
        <button onclick='printtag("rel");'type="button" class="btn btn-light text-center"> <i class="fa fa-print"></i> Imprimir</button>
        <hr>
        <h1 class="h2">Clientes</h1>
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Endereço</th>
                    <th>Data do Cadastro</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalUser = 0;
                $read= new Read();
                $read->ExeRead("clientes");
                foreach($read->getResult() as $dados){
                    extract($dados);
                    $valida_cpf = new ValidaCPFCNPJ($cpf);
                ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $nome; ?></td>
                    <td><?php echo $valida_cpf->formata(); ?></td>
                    <td><?php echo $endereco; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($created)); ?></td>
                </tr>
                <?php $totalUser+=1;} ?>
                <tr>
                    <td colspan="3"></td>
                    <td><strong>Total de clientes</strong></td>
                    <td><?php echo $totalUser ?></td>
                </tr>
            </tbody>
        </table>
        <!-- CONTAS-->
        <h1 class="h2">Dividas</h1>
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Status</th>
                    <th>Data para pagamento</th>
                    <th>Ultimo pagamento</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalDivida = 0;
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
                    <td><?php echo $ultimo_pagamento ?  date('d/m/Y', strtotime($ultimo_pagamento)) : '-' ; ?></td>
                    <td>R$ <?php echo number_format($valor, 2, ',', ''); ?></td>
                </tr>
                <?php $totalDivida+=$valor;} ?>
                <tr>
                    <td colspan="4"></td>
                    <td><strong>Total</strong></td>
                    <td><?php echo number_format($totalDivida, 2, ',', '') ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php }else{
    require_once('404.php');
}