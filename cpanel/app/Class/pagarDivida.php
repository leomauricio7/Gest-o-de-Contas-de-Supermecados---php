<?php

require_once'../Conf.inc';
require_once'../../vendor/autoload.php';

setDividaPP();

function setDividaPP(){
    $valorAntigo  = 0;
    $valorNovo = 0;
    $read = new Read();
    $read->ExeRead('compras', 'where id = :id', 'id='.$_GET['id']);
    foreach($read->getResult() as $dados){
        extract($dados);
        $valorAntigo = $valor_atual;
    }
    $valorNovo = $valorAntigo - $_GET['valor'] < 0 ? 0 : $valorAntigo - $_GET['valor'];
    $status = $valorNovo == 0 ? 2 : 4;
    $update = new Update();
    $dados = ['valor_atual'=> $valorNovo, 'valor_ultimo_pagamento'=> $_GET['valor'], 'id_status'=>$status];
    $update->ExeUpdate('compras', $dados, 'where id = :id', 'id='.$_GET['id']);
    if($update->getRowCount() > 0){
        return ['msg'=>'Divida quitada'];
    }else{
        return ['msg' =>'Erro na quitação da divida'];
    }

}
