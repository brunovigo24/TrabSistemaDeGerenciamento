<?php
function conectar(){
    $username = "root";
    $password = "";

    try{
        $conn = new PDO('mysql:host=localhost;dbname=LabProject', $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
}   

function cadastro($conn, $tabela, $campos1, $valores, $data){

    $sql = "INSERT INTO $tabela ($campos1) VALUES ($valores)";
    $stmt= $conn->prepare($sql);
    $stmt->execute($data);
    
    if ( $stmt->rowCount() ) {
        echo "Registro Inserido com Sucesso";
      } else {
        echo "Nenhum resultado retornado.";
      }
}

function atualizar($conn, $tabela, $campos, $data){
    
    $sql = "update $tabela set $campos where id = :id";
    $stmt= $conn->prepare($sql);
    $stmt->execute($data);
    
    if ( $stmt->rowCount() ) {
        echo "Registro Atualizado  com Sucesso";
      } else {
        echo "Nenhum resultado retornado.";
      }
}

function deletar($conn, $tabela, $id){
    
    $sql = "delete from $tabela where id = :id";
    $stmt= $conn->prepare($sql);
    $stmt->execute(array(':id' => $id));
    
    if ($stmt->rowCount()) {
        echo "Registro Deletado  com Sucesso";
      } else {
        echo "Nenhum resultado retornado.";
      }
}


function listarColaboradores($conn){
    $stmt = $conn->prepare("SELECT * FROM colaboradores");
    $stmt->execute();

    while($row = $stmt->fetch()) {
        print_r($row);
        //echo $row['id'];
        //var_dump($row);
        echo "<br>";
    }
}

function listarWhere($conn, $id){
    $stmt = 
    $conn->prepare('SELECT * FROM colaboradores WHERE id = :id');
    $stmt->execute(array(':id' => $id));

    while($row = $stmt->fetch()) {
        print_r($row);
        echo "<br>";
    }
}

function listarGerente($conn, $cargo){
    $stmt = $conn->prepare('select nome, cargo, cpf from colaboradores where cargo = :cargo  order by nome asc');
    $stmt->execute(array(':cargo' => $cargo));

    while($row = $stmt->fetch(PDO :: FETCH_ASSOC)) {
        print_r($row);
        echo "<br>";
    }
}
function listarProjetos($conn){
    $stmt = $conn->prepare("SELECT * FROM projetos");
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    if ( count($result) ) {
        foreach($result as $row) {
          print_r($row); echo "<br>";
        }
      } else {
        echo "Nennhum resultado retornado.";
      }

}
function listarProjetosStatus($conn,$status){
    $stmt = $conn->prepare('select projetos.nome, projetos.descricao, projetos.dataInicio, colaboradores.nome from projetos, colaboradores where projetos.status = :status and projetos.responsavel = colaboradores.id');
    $stmt->execute(array(':status' => $status));

    while($row = $stmt->fetch()) {
        print_r($row);
        echo "<br>";
    }
}

?>