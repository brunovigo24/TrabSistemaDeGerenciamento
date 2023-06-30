<?php
class Myconnect{
    private $username = "root";
    private $password = "";
    public $conn;
    public function __construct()
    {
        
        /*A estrutura try...catch deve ser utilizada em operações que podem falhar. Assim, quando a falha acontece a aplicação tem o controle de como era será tratada*/
        try{
            $this->conn = new PDO('mysql:host=localhost;dbname=LabProject', $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        }catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }    
    }

    
}