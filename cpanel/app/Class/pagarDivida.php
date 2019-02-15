<?php

require_once'../Conf.inc';
require_once'../../vendor/autoload.php';
$rs = null;
if($_POST['tipo'] == 'pp'){
    $rs = setDividaPP();
    echo  json_encode($rs);
    exit;
}else{
    $rs = setDividaPC();
    echo json_encode($rs);
    exit;
}

function setDividaPC(){
    $update = new Update();
    $dados = ['valor'=> '0.00','id_status'=>2];
    $update->ExeUpdate('contas', $dados, 'where id = :id', 'id='.$_POST['id']);
    if($update->getRowCount() > 0){
        return $msg = ['msg'=>'Divida quitada'];
    }else{
        return $msg = ['msg' =>'Erro na quitação da divida'];
    }
}

function setDividaPP(){
    $valorAntigo  = '';
    $valorNovo = 0;;
    $read = new Read();
    $read->ExeRead('contas', 'where id = :id', 'id='.$_POST['id']);
    foreach($read->getResult() as $dados){
        extract($dados);
        $valorAntigo = $valor;
    }
    $valorNovo = $valorAntigo - $_POST['valor'] < 0 ? 0 : $valorAntigo - $_POST['valor'];
    $status = $valorNovo == 0 ? 2 : 4;
    $update = new Update();
    $dados = ['valor'=> $valorNovo,'id_status'=>$status];
    $update->ExeUpdate('contas', $dados, 'where id = :id', 'id='.$_POST['id']);
    if($update->getRowCount() > 0){
        return $msg = ['msg'=>'Divida quitada'];
    }else{
        return $msg = ['msg' =>'Erro na quitação da divida'];
    }

}
