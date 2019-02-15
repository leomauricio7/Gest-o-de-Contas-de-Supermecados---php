<?php

class Read extends Conn {

    private $Select;
    private $Places;
    private $Result;
    private $Read;
    private $Conn;

    public function ExeRead($Tabela, $Termos = null, $ParseString = null) {
        if (!empty($ParseString)) {
            parse_str($ParseString, $this->Places);
        }

        $this->Select = "SELECT * FROM {$Tabela} {$Termos}";
        $this->Execute();
    }

    public function getContas($Termos = null) {
        if (empty($Termos)):
            $Termos = '';
        endif;
        $this->Select = 'SELECT sc.status status, cl.nome as cliente, c.valor, c.data_para_pagamento, c.id, c.data_pagamento as ultimo_pagamento, c.id_status FROM contas c inner join clientes cl on c.id_cliente = cl.id inner join status_compra sc on c.id_status = sc.id ' . $Termos;
        $this->ExecuteSQL();
    }

    public function getCompras($Termos = null) {
        if (empty($Termos)):
            $Termos = '';
        endif;
        $this->Select = 'SELECT sc.status, c.id_status, c.id_conta, c.valor, c.valor_atual, c.valor_ultimo_pagamento, c.created, c.updated, c.id as id_compra, c.id_status FROM compras c inner join status_compra sc on c.id_status = sc.id ' . $Termos;
        $this->ExecuteSQL();
    }

    public function getResult() {
        return $this->Result;
    }

    public function getRowCount() {
        return $this->Read->rowCount();
    }

    private function Connect() {
        $this->Conn = parent::getConn();
        $this->Read = $this->Conn->prepare($this->Select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
    }

    private function getSyntax() {
        if ($this->Places):
            foreach ($this->Places as $Vinculo => $Valor):
                if ($Vinculo == 'limit' || $Vinculo == 'offset'):
                    $Valor = (int) $Valor;
                endif;
                $this->Read->bindValue(":{$Vinculo}", $Valor, (is_int($Valor) ? PDO::PARAM_INT : PDO::PARAM_STR));
            endforeach;
        endif;
    }

    private function Execute() {
        $this->Connect();
        try {
            $this->getSyntax();
            $this->Read->execute();
            $this->Result = $this->Read->fetchAll();
        } catch (PDOException $e) {
            $this->Result = null;
            echo 'Message: ' . $e->getMessage();
        }
    }

    private function ExecuteSQl() {
        $this->Connect();
        try {
            $this->Read->execute();
            $this->Result = $this->Read->fetchAll();
        } catch (PDOException $e) {
            $this->Result = null;
            echo 'Message: ' . $e->getMessage();
        }
    }

}
