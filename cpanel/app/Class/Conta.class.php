<?php

class Conta {

    public $Titulo;
    public $Conteudo;
    public $Dados;

    const Entity = 'contas';

    function createConta(array $Dados) {
        $this->Dados = $Dados;

        $create = new Create();
        $create->ExeCreate(self::Entity, $this->Dados);
        if ($create->getResult()):
            $this->Result = $create->getResult();
            $this->Msg = '<div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        Conta cadastrado com sucesso!
                    </div>';
        else:
            $this->Result = $create->getResult();
            $this->Msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        Erro no processamento do cadastro.
                    </div>';
        endif;
    }

    function getResult() {
        return $this->Result;
    }

    function getMsg() {
        return $this->Msg;
    }

}
