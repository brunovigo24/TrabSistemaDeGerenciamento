<?php
include("./Model/Tarefa.php");
$tarefa1 = new Tarefa();

if(isset($_POST["nome"]) && isset($_POST["descricao"]) && 
isset($_POST["prazo"]) && isset($_POST["projeto"]) && 
isset($_POST["responsavel"]) && isset($_POST["acao"])){

    if(!empty($_POST["nome"]) && !empty($_POST["descricao"]) && 
    !empty($_POST["prazo"]) && !empty($_POST["projeto"]) && 
    !empty($_POST["responsavel"]) && !empty($_POST["acao"])){
      
        $nome = $_POST["nome"];
        $descricao = $_POST["descricao"];
        $prazo = $_POST["prazo"];
        $projeto = $_POST["projeto"];
        $responsavel = $_POST["responsavel"];
        $acao = $_POST["acao"];

        
        if($acao=="inserir"){
            $campos1 = "nome, descricao, prazo, projeto, responsavel";
            $campos2 = ":nome, :descricao, :prazo, :projeto, :responsavel";
            $tabela = "tarefas";
            
            $dados = array('nome'=>$nome, 'descricao'=>$descricao, 'prazo'=>$prazo, 'projeto'=>$projeto, 'responsavel'=>$responsavel);            
            $result = $tarefa1->cadastrar($campos1, $campos2, $dados);       
    
            if($result){    
                header("Location: ./index.php?pagina=tarefa.php&acao=listar&mensagem=sucesso");    
            }else{
                header("Location: ./index.php?pagina=tarefa.php&acao=listar&mensagem=erro");
            }            
        }elseif($acao=="editar"){
            if(isset($_POST["id"]) && !empty($_POST["id"])){
                $id = $_POST["id"];
                $campos = "nome = :nome, descricao = :descricao, prazo = :prazo, projeto = :projeto, responsavel = :responsavel";
                $tabela ="tarefas";

                $dados = array('nome'=>$nome, 'descricao'=>$descricao, 'prazo'=>$prazo, 'projeto'=>$projeto, 'responsavel'=>$responsavel,'id'=>$id);
                print_r($dados);
                $result = $tarefa1->atualizar($campos, $dados);       

                if($result){
                    header("Location: ./index.php?pagina=tarefa.php&acao=listar&mensagem=sucesso");
                }else{
                    header("Location: ./index.php?pagina=tarefa.php&acao=listar&mensagem=erro");
                }    
            }else{
                header("Location: ./index.php?pagina=tarefa.php&acao=listar&mensagem=erro");
            }
            
        }elseif($acao=="excluir"){
            
            if(isset($_GET["id"]) && !empty($_GET["id"])){
                $id = $_GET["id"];
                $result = $tarefa1->deletar($id);      

                if($result){
                    header("Location: ./index.php?pagina=tarefa.php&acao=listar&mensagem=sucesso");
                }else{
                    header("Location: ./index.php?pagina=tarefa.php&acao=listar&mensagem=erro");
                }    
            }else{
                header("Location: ./index.php?pagina=tarefa.php&acao=listar&mensagem=erro");
            }
            
        }else{
            echo "Em construção";
        }

        
    }else{
        header("Location: ./index.php?pagina=tarefa.php&acao=listar&mensagem=erro");
    }
}else{
    if(isset($_GET["acao"]) && isset($_GET["id"]) && !empty($_GET["acao"]) && !empty($_GET["id"])){
        $acao = $_GET["acao"];
        $id = $_GET["id"];

        if($acao == "excluir"){
            $result = $tarefa1->deletar($id);      
            if($result){
                header("Location: ./index.php?pagina=tarefa.php&acao=listar&mensagem=sucesso");
            }else{
                header("Location: ./index.php?pagina=tarefa.php&acao=listar&mensagem=erro");
            } 
        }
    }else{
        header("Location: ./index.php?pagina=tarefa.php&acao=listar&mensagem=erro");
    }
}
?>