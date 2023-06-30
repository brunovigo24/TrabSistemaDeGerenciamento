<?php
require_once ("Myconnect.php");

class Colaborador extends Myconnect{
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

    public function listar(){
        $stmt = $this->conn->prepare("SELECT * FROM colaboradores");
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO :: FETCH_ASSOC);
        //var_dump($result);
        return $result;
    }
    public function listarSelect(){
        $stmt = $this->conn->prepare("SELECT id, nome FROM colaboradores order by nome asc");
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

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["arquivo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["arquivo"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "Arquivo não é uma imagem.";
            $uploadOk = 0;
        }
        }

        if (file_exists($target_file)) {
        echo "Desculpe, arquivo já existe.";
        $uploadOk = 0;
        }

        if ($_FILES["arquivo"]["size"] > 500000) {
        echo "Desculpe, o formato deste arquivo muito grande.";
        $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "Desculpe, somente extensões JPG, JPEG, PNG & GIF são válidas.";
        $uploadOk = 0;
        }

        if ($uploadOk == 0) {

        } else {
            if (move_uploaded_file($_FILES["arquivo"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["arquivo"]["name"])). " has been uploaded.";
            } else {
                echo "Desculpe, ocorreu um erro de ulpoad do aquivo.";
            }
        }
       
        $sql = "INSERT INTO colaboradores (".$campos1_poo.") VALUES (".$campos2_poo.")";
        $stmt= $this->conn->prepare($sql);
        $data_poo["arquivo"]=$target_file;
        $stmt->execute($data_poo);
        
        if ($stmt->rowCount()) {
           return 1;
        } else {
           return 0;
        }
    }
    public function atualizar($campos, $data){

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["arquivo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["arquivo"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "Arquivo não é uma imagem.";
            $uploadOk = 0;
        }
        }

        if (file_exists($target_file)) {
        echo "Desculpe, arquivo já existe.";
        $uploadOk = 0;
        }

        if ($_FILES["arquivo"]["size"] > 500000) {
        echo "Desculpe, o formato deste arquivo muito grande.";
        $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "Desculpe, somente extensões JPG, JPEG, PNG & GIF são válidas.";
        $uploadOk = 0;
        }

        if ($uploadOk == 0) {
        } else {
            if (move_uploaded_file($_FILES["arquivo"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["arquivo"]["name"])). " has been uploaded.";
            } else {
                echo "Desculpe, ocorreu um erro de ulpoad do aquivo.";
            }
        }
    
        $sql = "update colaboradores set $campos where id = :id";
        $stmt= $this->conn->prepare($sql);
        $data["arquivo"]=$target_file;
        $stmt->execute($data);
        
        if ($stmt->rowCount()) {
            return 1;
         } else {
            return 0;
         }
    }
    public function deletar($id){
    
        $sql = "delete from Colaboradores where id = :id";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute(array(':id' => $id));
        
        if ($stmt->rowCount()) {
            return 1;
         } else {
            return 0;
         }
    }
    public function carregarColaborador($id){
        $stmt = $this->conn->prepare('SELECT * FROM colaboradores WHERE id = :id');
        $stmt->execute(array('id' => $id));

        $result = $stmt->fetchAll(PDO :: FETCH_ASSOC);
        return $result;
    }
    public function carregarColaboradorGerente(){
        $stmt = $this->conn->prepare('SELECT * FROM colaboradores WHERE cargo = :cargo');
        $stmt->execute(array('cargo' => 'Gerente'));

        $result = $stmt->fetchAll(PDO :: FETCH_ASSOC);
        return $result;
    }
    public function listarColab(){
        $stmt = $this->conn->prepare('select p.id, p.nome from colaboradores as p');
        $stmt->execute();

        $result = $stmt->fetchAll(PDO :: FETCH_ASSOC);
        return $result;
    }
}