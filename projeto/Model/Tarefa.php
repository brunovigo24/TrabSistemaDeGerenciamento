<?php
require_once ("Myconnect.php");

class Tarefa extends Myconnect{
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

    public function listarTarefas(){
        $stmt = $this->conn->prepare('SELECT t.id, t.nome as '."Tarefa".', t.descricao, 
        t.prazo, c.nome as '."colaborador".', p.nome  as '."projeto".' from tarefas as t,
        projetos as p, colaboradores as c 
        where t.responsavel = c.id and t.projeto = p.id');
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO :: FETCH_ASSOC);
        return $result;  
    }
    public function listarSelect(){
        $stmt = $this->conn->prepare("SELECT id, nome FROM tarefas order by nome asc");
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
       
        $sql = "INSERT INTO tarefas ($campos1_poo) VALUES ($campos2_poo)";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute($data_poo);
        
        if ($stmt->rowCount()) {
           return 1;
        } else {
           return 0;
        }
    }
    public function atualizar($campos, $data){
    
        $sql = "update tarefas set $campos where id = :id";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute($data);
        
        if ($stmt->rowCount()) {
            return 1;
         } else {
            return 0;
         }
    }
    public function deletar($id){
    
        $sql = "delete from tarefas where id = :id";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute(array(':id' => $id));
        
        if ($stmt->rowCount()) {
            return 1;
         } else {
            return 0;
         }
    }
    public function carregarTarefas($id){
        $stmt = $this->conn->prepare('select t.nome as "Tarefas", t.descricao, 
        t.prazo, c.nome as "colaborador", p.nome from tarefas as t,
        projetos as p, colaboradores as c 
        where t.id =:id and t.responsavel = c.id and t.projeto = p.id');
        $stmt->execute(array(':id' => $id));

        $result = $stmt->fetchAll(PDO :: FETCH_ASSOC);
        return $result;
    }
}
   