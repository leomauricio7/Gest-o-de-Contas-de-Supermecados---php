<?php
require_once '../Conf.inc';
require_once '../../vendor/autoload.php';
//valores das ordens antigasS
$valorAntigo = (int) $_GET['ordem'];
$valorNovo = null;
//verificando se o valor da ordem é 1
if($valorAntigo == 1)
{
 echo '<script>history.go(-1)</script>';   
}
else
{
    $valorNovo = (int) $valorAntigo-1;
    //pegandos os ids das permissões
    $readAntiga = new Read();
    $readAntiga->ExeRead('user_tipo', "WHERE ordem = $valorAntigo");
    foreach($readAntiga->getResult() as $dados){
            extract($dados);
            $idPermissaoAntiga = $id;//id da ordem antiga que vamos alterar
    }
    $readNovo = new Read();
    $valorAntigoNovo = $valorAntigo-1;
    $readNovo->ExeRead('user_tipo', "WHERE ordem = $valorAntigoNovo");
    foreach($readNovo->getResult() as $dados){
            extract($dados);
            $idPermissaoAntes = $id;//id da ordem que antecede a ordem antiga
    }
    //atualizando nas tabelas
    $update = new Update();
    $dados = ['ordem' => $valorNovo];
    $update->ExeUpdate("user_tipo", $dados, "WHERE id = :id", "id=$idPermissaoAntiga");
    if($update->getResult())
    {
        $dados=['ordem'=>$valorNovo+1];
        $update->ExeUpdate("user_tipo", $dados, "WHERE id = :id", "id=$idPermissaoAntes");
        if($update->getResult())
        {
                $_SESSION['msg'] = '<div class="alert alert-success alert-dismissible" role="alert">
                    Ordem de acesso alterada com sucesso
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" style="cursor: pointer;">&times;</span>
                    </button>
                </div>';
            echo '<script>history.go(-1)</script>';
        }
        else
        {
                $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible" role="alert">
                    Erro no processamento da ordem de acesso.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" style="cursor: pointer;">&times;</span>
                    </button>
                </div>';
            echo '<script>history.go(-1)</script>'; 
        }
    }
    else
    {
            $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible" role="alert">
                Erro no processamento da ordem de acesso.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="cursor: pointer;">&times;</span>
                </button>
            </div>';
            echo '<script>history.go(-1)</script>';     
    }           
}
