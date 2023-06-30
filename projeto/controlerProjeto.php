<?php

include("./Model/Projeto.php");
$projeto = new Projeto();

if(isset($_POST["nome"]) && isset($_POST["descricao"]) && 
isset($_POST["responsavel"]) && isset($_POST["status"]) && 
isset($_POST["dataInicio"]) && isset($_POST["acao"])){
    
    if(!empty($_POST["nome"]) && !empty($_POST["descricao"]) && 
    !empty($_POST["responsavel"]) && !empty($_POST["status"]) && 
    !empty($_POST["dataInicio"]) && !empty($_POST["acao"])){
      
        $nome = $_POST["nome"];
        $descricao = $_POST["descricao"];
        $responsavel = $_POST["responsavel"];
        $status = $_POST["status"];
        $dataInicio = $_POST["dataInicio"];
        $acao = $_POST["acao"];
        
        
        
        if($acao=="inserir"){
         
            $campos1 = "nome, descricao, responsavel, status, dataInicio";
            $campos2 = ":nome, :descricao, :responsavel, :status, :dataInicio";
            $tabela = "projetos";
            
            $dados = array('nome'=>$nome, 'descricao'=>$descricao, 'responsavel'=>$responsavel, 'status'=>$status, 'dataInicio'=>$dataInicio);
            $result = $projeto->cadastrar($campos1, $campos2, $dados);       
    
            if($result){
                header("Location: ./index.php?pagina=projeto.php&acao=listar&mensagem=sucesso");   
            }else{
                header("Location: ./index.php?pagina=projeto.php&acao=listar&mensagem=erro");
            }
        }elseif($acao=="editar"){
            if(isset($_POST["id"]) && !empty($_POST["id"])){
                $id = $_POST["id"];
                $campos = "nome = :nome, descricao = :descricao, responsavel = :responsavel, status = :status, dataInicio = :dataInicio";
                $tabela = "projetos";

                $dados = array('nome'=>$nome, 'descricao'=>$descricao, 'responsavel'=>$responsavel,'status'=>$status, 'dataInicio'=>$dataInicio, 'id'=>$id);
                print_r($dados);
                $result = $projeto->atualizar($campos, $dados); 

                if($result){
                    header("Location: ./index.php?pagina=projeto.php&acao=listar&mensagem=sucesso");
                }else{
                    header("Location: ./index.php?pagina=projeto.php&acao=listar&mensagem=erro");
                }    
            }else{
                header("Location: ./index.php?pagina=projeto.php&acao=listar&mensagem=erro");
            }
            
        }elseif($acao=="excluir"){
            
            if(isset($_GET["id"]) && !empty($_GET["id"])){
                $id = $_GET["id"];
                $result = $projeto->deletar($id);      

                if($result){
                    header("Location: ./index.php?pagina=projeto.php&acao=listar&mensagem=sucesso");
                }else{
                    header("Location: ./index.php?pagina=projeto.php&acao=listar&mensagem=erro");
                }    
            }else{
                header("Location: ./index.php?pagina=projeto.php&acao=listar&mensagem=erro");
            }
            
        }else{
            echo "Em construção";
        }

        
    }else{
        header("Location: ./index.php?pagina=projeto.php&acao=listar&mensagem=erro");
    }
}else{
    if(isset($_GET["acao"]) && isset($_GET["id"]) && !empty($_GET["acao"]) && !empty($_GET["id"])){
        $acao = $_GET["acao"];
        $id = $_GET["id"];

        if($acao == "excluir"){
            $result = $projeto->deletar($id);      
            if($result){
                header("Location: ./index.php?pagina=projeto.php&acao=listar&mensagem=sucesso");
            }else{
                header("Location: ./index.php?pagina=projeto.php&acao=listar&mensagem=erro");
            } 
        }
    }else{
        header("Location: ./index.php?pagina=projeto.php&acao=listar&mensagem=erro");
    }
}
?>