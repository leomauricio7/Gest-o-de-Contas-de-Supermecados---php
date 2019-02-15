<?php

require_once '../Conf.inc';
require_once '../../vendor/autoload.php';
//valores das ordens antigasS
$id = (int) $_GET['id'];

//pegandos os ids das permissões
$read = new Read();
$read->ExeRead('user_permision', "WHERE id = $id");
foreach ($read->getResult() as $dados) {
    extract($dados);
    $idSituacaoPermissaoAntiga = $id_situacao_permission; //id da ordem antiga que vamos alterar
}
if ($idSituacaoPermissaoAntiga == 0) {
    $idSituacaoPermissaoNova = 1;
} else {
    $idSituacaoPermissaoNova = 0;
}
//atualizando nas tabelas
$update = new Update();
$dados = ['id_situacao_permission' => $idSituacaoPermissaoNova];
$update->ExeUpdate("user_permision", $dados, "WHERE id = :id", "id=$id");
if ($update->getResult()) {
    $_SESSION['msg'] = '<div class="alert alert-success alert-dismissible" role="alert">
                Permissão liberada com sucesso.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="cursor: pointer;">&times;</span>
                </button>
            </div>';
    echo '<script>history.go(-1)</script>';
} else {
    $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible" role="alert">
                Erro no processamento da permissão.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="cursor: pointer;">&times;</span>
                </button>
            </div>';
    echo '<script>history.go(-1)</script>';
}           

