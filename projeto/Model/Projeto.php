<?php
require_once ("Myconnect.php");

class Projeto extends Myconnect{
    private $campos1, $campos2, $data;

    public function getCampos1(){
        return $this->campos1;
    }
    public function getCampos2(){
        return $this->campos2;
    }
    public function getdata(){
        return $this->data;
    }

     public function listarNome(){
        $stmt = $this->conn->prepare("SELECT id, nome FROM projetos order by nome asc");
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO :: FETCH_ASSOC);       
        return $result;    
    }
    public function cadastrar($campos1, $campos2, $data){
        $this->campos1 = $campos1;
        $this->campos2 = $campos2;
        $this->data = $data;

        $campos1_poo =  $this->getCampos1();
        $campos2_poo =  $this->getCampos2();
        $data_poo =  $this->getdata();
       
        $sql = "INSERT INTO projetos ($campos1_poo) VALUES ($campos2_poo)";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute($data_poo);
        
        if ($stmt->rowCount()) {
           return 1;
        } else {
           return 0;
        }
    }
    public function atualizar($campos, $data){

        $sql = "update projetos set $campos where id = :id";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute($data);
        
        if ($stmt->rowCount()) {
            return 1;
         } else {
            return 0;
         }
    }
    public function deletar($id){
    
        $sql = "delete from projetos where id = :id";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute(array(':id' => $id));
        
        if ($stmt->rowCount()) {
            return 1;
         } else {
            return 0;
         }
    }
    public function carregarProjetos($id){
        
        $stmt = $this->conn->prepare('SELECT p.id, p.nome as '."Projeto".', p.descricao, p.dataInicio, 
        c.nome 
        from projetos as p, colaboradores as c 
        where p.responsavel = c.id and p.id = :id');
        $stmt->execute(array('id' => $id));

        $result = $stmt->fetchAll(PDO :: FETCH_ASSOC);
        return $result;
    }

    public function listarProjetosStatus($status){
        $stmt = $this->conn->prepare('select p.id, p.nome as '."Projeto".', p.descricao, p.dataInicio, 
        c.nome 
        from projetos as p, colaboradores as c 
        where p.status = :status and p.responsavel = c.id');
        $stmt->execute(array(':status' => $status));

        $result = $stmt->fetchAll(PDO :: FETCH_ASSOC);
        return $result;
    }

    public function listarProjetosCurto($status){
        $stmt = $this->conn->prepare('select p.id, p.nome from projetos as p where p.status = :status');
        $stmt->execute(array(':status' => $status));

        $result = $stmt->fetchAll(PDO :: FETCH_ASSOC);
        return $result;
    }
    public function carregarTarefas($projeto){
        $stmt = $this->conn->prepare('select t.id, t.nome from tarefas as t
        where t.projeto = :id');
        $stmt->execute(array(':id' => $projeto));

        $result = $stmt->fetchAll(PDO :: FETCH_ASSOC);
        return $result;
    }
}