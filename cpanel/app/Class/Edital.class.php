<?php

class Edital {

    public $Titulo;
    public $Conteudo;
    public $Dados;

    const Entity = 'editais';

    function createEdital(array $Dados) {
        $this->Dados = $Dados;
        $this->Dados['termo_adesao'] = $this->Dados['termo_adesao']['name'];
        $this->Dados['contrato'] = $this->Dados['contrato']['name'];

        $create = new Create();
        $create->ExeCreate(self::Entity, $this->Dados);
        if ($create->getResult()):
            $this->Result = $create->getResult();
            $this->Msg = '<div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        Edital publicado com sucesso!
                    </div>';
        else:
            $this->Result = $create->getResult();
            $this->Msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        Erro no processamento do edital.
                    </div>';
        endif;
    }

    function createEditalIN(array $Dados) {
        $this->Dados = $Dados;
        $this->Dados['link_aviso'] = $this->Dados['link_aviso']['name'];
        $this->Dados['link_edital'] = $this->Dados['link_edital']['name'];

        $create = new Create();
        $create->ExeCreate(self::Entity, $this->Dados);
        if ($create->getResult()):
            $this->Result = $create->getResult();
            $this->Msg = '<div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        Edital publicado com sucesso!
                    </div>';
        else:
            $this->Result = $create->getResult();
            $this->Msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        Erro no processamento do edital.
                    </div>';
        endif;
    }

    public function update(array $dados, $idLicitacao) {
        $tipo = $dados['id_tipo'];
        $dados['id_tipo'] = (int) Validation::getTipoEdital($dados['id_tipo']);
        $dados['id_situacao'] = (int) $dados['id_situacao'];
        $dados['termo_adesao'] = ($_FILES['termo_adesao']['name']);
        $dados['contrato'] = ($_FILES['contrato']['name']);

        $uploud = new Uploud();
        if (!empty($_FILES['termo_adesao']['name'])) {
            $file_termo = $_FILES['termo_adesao'];
            $uploud->editFile($file_termo, 'editais/' . $dados['ano'] . '/' . $tipo . '/' . $idLicitacao . '/');
            $dadosUpdate = ['ano' => $dados['ano'], 'descricao' => $dados['descricao'], 'id_tipo' => $dados['id_tipo'], 'lei' => $dados['lei'], 'dataCertame' => $dados['dataCertame'], 'id_situacao' => $dados['id_situacao'], 'tags' => $dados['tags'], 'termo_adesao' => $dados['termo_adesao']];
        }
        if (!empty($_FILES['contrato']['name'])) {
            $file_contrato = $_FILES['contrato'];
            if (!empty($_FILES['termo_adesao']['name'])) {
                $uploud->editFile($file_contrato);
            } else {
                $uploud->editFile($file_contrato, 'editais/' . $dados['ano'] . '/' . $tipo . '/' . $idLicitacao . '/');
            }
            $dadosUpdate = ['ano' => $dados['ano'], 'descricao' => $dados['descricao'], 'id_tipo' => $dados['id_tipo'], 'lei' => $dados['lei'], 'dataCertame' => $dados['dataCertame'], 'id_situacao' => $dados['id_situacao'], 'tags' => $dados['tags'], 'contrato' => $dados['contrato']];
        }
        if (!empty($_FILES['contrato']['name']) && !empty($_FILES['termo_adesao']['name'])) {
            $dadosUpdate = ['ano' => $dados['ano'], 'descricao' => $dados['descricao'], 'id_tipo' => $dados['id_tipo'], 'lei' => $dados['lei'], 'dataCertame' => $dados['dataCertame'], 'id_situacao' => $dados['id_situacao'], 'tags' => $dados['tags'], 'contrato' => $dados['contrato'], 'termo_adesao' => $dados['termo_adesao']];
        } else {
            $dadosUpdate = ['ano' => $dados['ano'], 'descricao' => $dados['descricao'], 'id_tipo' => $dados['id_tipo'], 'lei' => $dados['lei'], 'dataCertame' => $dados['dataCertame'], 'id_situacao' => $dados['id_situacao'], 'tags' => $dados['tags']];
        }
        $update = new Update();
        $update->ExeUpdate('editais', $dadosUpdate, 'WHERE id = :id', 'id=' . $idLicitacao . '');
        if ($update->getResult()):
            $this->Msg = '<div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 align="center"><i class="fa fa-check-circle"></i> Alterações realizadas com sucesso.</h5>
                </div>';
        else:
            $this->Msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 align="center"><i class="fa fa-check-circle"></i> Erro no processamento.</h5>
                </div>';
        endif;
    }

    public function updateEditalIN(array $dados, $idLicitacao) {
        $tipo = $dados['id_tipo'];
        $dados['id_tipo'] = Validation::getTipoEdital($dados['id_tipo']);
        $dados['link_aviso'] = ($_FILES['linkAviso']['name']);
        $dados['link_edital'] = ($_FILES['linkEdital']['name']);

        //objeto para realizar uploud dos arquivos
        $uploud = new Uploud();
        //verifica se o link de aviso foi enviado
        if (!empty($_FILES['linkAviso']['name'])) {
            $file_aviso = $_FILES['linkAviso'];
            $uploud->editFile($file_aviso, 'editais/' . $dados['ano'] . '/' . $tipo . '/' . $idLicitacao . '/');
            $dadosUpdate = [
                'ano' => $dados['ano'],
                'id_tipo' => $dados['id_tipo'],
                'lei' => $dados['lei'],
                'dataRetirada' => $dados['dataRetirada'],
                'dataCertame' => $dados['dataCertame'],
                'horaCertame' => $dados['horaCertame'],
                'descricao' => $dados['descricao'],
                'id_situacao' => $dados['id_situacao'],
                'tags' => $dados['tags'],
                'link_aviso' => $dados['link_aviso']
            ];
        }
        //verifica se o edital  foi enviado
        if (!empty($_FILES['linkEdital']['name'])) {
            $file_edital = $_FILES['linkEdital'];
            if (!empty($_FILES['linkAviso']['name'])) {
                $uploud->editFile($file_edital); 
            }else{
               $uploud->editFile($file_edital, 'editais/' . $dados['ano'] . '/' . $tipo . '/' . $idLicitacao . '/'); 
            }
            $dadosUpdate = [
                'ano' => $dados['ano'],
                'id_tipo' => $dados['id_tipo'],
                'lei' => $dados['lei'],
                'dataRetirada' => $dados['dataRetirada'],
                'dataCertame' => $dados['dataCertame'],
                'horaCertame' => $dados['horaCertame'],
                'descricao' => $dados['descricao'],
                'id_situacao' => $dados['id_situacao'],
                'tags' => $dados['tags'],
                'link_edital' => $dados['link_edital']
            ];
        }
        //verifica se não envidao algum aviso de edital ou edital
        if (!empty($_FILES['linkAviso']['name']) && !empty($_FILES['linkEdital']['name'])) {
            $dadosUpdate = [
                'ano' => $dados['ano'],
                'id_tipo' => $dados['id_tipo'],
                'lei' => $dados['lei'],
                'dataRetirada' => $dados['dataRetirada'],
                'dataCertame' => $dados['dataCertame'],
                'horaCertame' => $dados['horaCertame'],
                'descricao' => $dados['descricao'],
                'id_situacao' => $dados['id_situacao'],
                'tags' => $dados['tags'],
                'link_aviso' => $dados['link_aviso'],
                'link_edital' => $dados['link_edital']
            ];
        }
        //verifica se não foi envidao algum aviso de edital ou edital
        if (empty($_FILES['linkAviso']['name']) and empty($_FILES['linkEdital']['name'])) {
            $dadosUpdate = [
                'ano' => $dados['ano'],
                'id_tipo' => $dados['id_tipo'],
                'lei' => $dados['lei'],
                'dataRetirada' => $dados['dataRetirada'],
                'dataCertame' => $dados['dataCertame'],
                'horaCertame' => $dados['horaCertame'],
                'descricao' => $dados['descricao'],
                'id_situacao' => $dados['id_situacao'],
                'tags' => $dados['tags']
            ];
        }
        //objeto para realizar as alterações no BD
        $update = new Update();
        $update->ExeUpdate('editais', $dadosUpdate, 'WHERE id = :id', 'id=' . $idLicitacao . '');
        if ($update->getResult()):
            $this->Msg = '<div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 align="center"><i class="fa fa-check-circle"></i> Alterações realizadas com sucesso.</h5>
            </div>';
        else:
            $this->Msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 align="center"><i class="fa fa-check-circle"></i> Erro no processamento.</h5>
            </div>';
        endif;
    }
    
    public function uploudMultiplo($table ,$File, $idLicitacao, $tipo, $ano){ 
        $Folder = 'arquivos/editais/' . $ano . '/' . $tipo . '/' . $idLicitacao;
        $create = new Create();
        if (isset($File) && !empty($File['name'][0])){
            $total = count($File['name']);
            for ($i = 0; $i < $total; $i++){
                move_uploaded_file($File['tmp_name'][$i], $Folder . '/' . $File['name'][$i]);
                $Dados = ['id_edital' => $idLicitacao, 'pdf' => $File['name'][$i]];
                $create->ExeCreate($table, $Dados);
            }
        }
    }
    
    function getResult() {
        return $this->Result;
    }

    function getMsg() {
        return $this->Msg;
    }

}
