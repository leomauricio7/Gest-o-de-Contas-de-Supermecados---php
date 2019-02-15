<?php

class Create extends Conn {

    private $Tabela;
    private $Dados;
    private $Result;
    private $Create;
    private $Conn;
    private $UltimoId;

    //Recebe a tabela e os dados
    public function ExeCreate($Tabela, array $Dados) {
        $this->Tabela = (string) $Tabela;
        $this->Dados = $Dados;

        $this->getSyntax();
        $this->Execute();
    }

    //retorna o  id do ultimo registro inserido
    public function getResult() {
        return $this->Result;
    }
    public function getUltimoId(){
        return $this->UltimoId;
    }
    //Pega a conexão PDO e prepara a query
    public function Connect() {
        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($this->Create);
    }

    //Cria a instrução SQL
    private function getSyntax() {
        $Fileds = implode(', ', array_keys($this->Dados));
        $Places = ':' . implode(', :', array_keys($this->Dados));
        $this->Create = "INSERT INTO {$this->Tabela} ({$Fileds}) VALUES ({$Places})";
    }

    //Obtem a conexão a syntax e executa a query!
    private function Execute() {
        $this->Connect();
        try {
            $this->Create->execute($this->Dados);
            $this->Result = $this->Conn->lastInsertId();
            $this->UltimoId = $this->Conn->lastInsertId();
        } catch (PDOException $e) {
            $this->Result = null;
            echo 'Message: ' . $e->getMessage();
        }
    }

}

