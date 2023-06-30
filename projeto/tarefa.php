<?php

require_once("./Model/Tarefa.php");
require_once("./Model/Colaborador.php");
require_once("./Model/Projeto.php");
$tarefa1 = new Tarefa();
$colaborador = new Colaborador();
$projeto = new Projeto();
//var_dump($tarefa1);
?>
<div>
<h2>Gestão de Tarefas</h2>
<a href="index.php?pagina=tarefa.php&acao=listar"><button class="button button1">Listar Todos</button></a>
<a href="index.php?pagina=tarefa.php&acao=inserir"><button class="button button2">Adicionar Tarefa</button></a>

</div>
<?php
if(isset($_GET["mensagem"]) && !empty($_GET["mensagem"])){
    $mensagem = $_GET["mensagem"];

    if($mensagem=="sucesso"){
    ?>
        <div class="alert success">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        Operação realizada com sucesso!!!.
        </div>
    <?php
    }else{
        ?>
        <div class="alert warning">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        Ocorreu um erro na operação com a tarefa, reveja os dados e tente novamente mais tarde. Obrigado!
        </div>
        <?php
    }
}

if(isset($_GET["acao"]) && !empty($_GET["acao"])){

    $acao = $_GET["acao"];

    if($acao=="listar"){
        $resultado = $tarefa1->listarTarefas();

        if (count($resultado)) {
        ?>
            <table id="customers">
                <tr>
                    <th>ITEM</th>
                    <th>NOME TAREFA</th>
                    <th>DESCRICAO</th>
                    <th>PRAZO</th>
                    <th>PROJETO</th>
                    <th>RESPONSAVEL</th>
                    <th>AÇÃO</th>
                </tr>
            <?php
                $i=1;  
                foreach($resultado as $row) {
                    $id = $row["id"];
                ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?=$row["Tarefa"]?></td>
                    <td><?=$row["descricao"]?></td>
                    <td><?=$row["prazo"]?></td>
                    <td><?=$row["projeto"]?></td>
                    <td><?=$row["colaborador"]?></td>
                    <td>
                    <a href="index.php?pagina=tarefa.php&acao=visualizar&id=<?=$id?>"><button class="button button4">Visualizar</button></a>
                    <a href="index.php?pagina=tarefa.php&acao=alterar&id=<?=$id?>"><button class="button button2">Alterar</button></a>
                    <a href="index.php?pagina=controlerTarefa.php&acao=excluir&id=<?=$id?>"><button class="button button3">Excluir</button></a>
                </td>

                </tr>        
                <?php  
                }
                ?>
            </table>
                <?php
        } else {
            echo "Nenhum resultado retornado.";
        }
    }elseif($acao=="inserir"){   // Inserir funcionando 
    ?>
    <h2>Adicionar Tarefa</h2>

    <div class="boxForm">
    <form action="controlerTarefa.php" method="post">
        <label for="tarefa">Nome Tarefa</label>
        <input type="text" id="tarefa" name="nome" placeholder="Nome dado a tarefa">

        <label for="descricao">Descricao</label>
        <input type="text" id="descricao" name="descricao" placeholder="Descrição da tarefa.">

        <label for="prazo">Prazo</label>
        <input type="text" id="prazo" name="prazo" placeholder="Prazo para executar a tarefa.">
        <?php
        $row = $projeto->listarProjetosCurto(1);
        ?>
        <label for="projeto">Projeto</label>
        <select id="projeto" name="projeto">
        <?php
        
        foreach($row as $dadosProjeto){
        ?>
            <option value=<?=$dadosProjeto['id']?>><?=$dadosProjeto['nome']?></option>
        <?php
        }
        ?>
        </select>
        <?php
        $row = $colaborador->listarColab();
        ?>
        <label for="responsavel">Responsavel</label>
        <select id="responsavel" name="responsavel">
        <?php
        foreach($row as $dadoscolaborador){
          ?>
          <option value=<?=$dadoscolaborador['id']?>><?=$dadoscolaborador['nome']?></option>
          <?php
        }
        ?>
        </select>
        <input type="hidden" name="acao" value="inserir">
        <input type="hidden" name = "status" value ="1">
        <input type="submit" value="Adicionar">
    </form>
    </div>

    <?php
    }elseif($acao=="alterar"){   // Alterar funcionando 
        if(isset($_GET["id"]) && !empty($_GET["id"])){
            $id = $_GET["id"];
            $row = $tarefa1->carregarTarefas($id);
            foreach($row as $dado)
        ?>
            <h2>Alterar Tarefa</h2>

            <div class="boxForm">
            <form action="controlerTarefa.php" method="post">
                <label for="Tarefa">Nome Tarefa</label>
                <input type="text" id="nome" name="nome" value="<?=$dado['Tarefas'];?>">

                <label for="descricao">Descricao</label>
                <input type="text" id="descricao" name="descricao" value="<?=$dado['descricao'];?>">

                <label for="prazo">Prazo</label>
                <input type="text" id="prazo" name="prazo" value="<?=$dado['prazo'];?>">
                <?php
                $row = $projeto->listarProjetosCurto(1);
                ?>
                <label for="projeto">Projeto</label>
                <select id="projeto" name="projeto">
                <?php
        
                foreach($row as $dadosProjeto){
               ?>
                <option value=<?=$dadosProjeto['id']?>>
                <?=$dadosProjeto['nome']?></option>
                <?php
                }
                ?>
                </select>
                <?php
                $row = $colaborador->listarColab();
                ?>
                <label for="responsavel">Responsavel</label>
                 <select id="responsavel" name="responsavel">
                 <?php
                foreach($row as $dadoscolaborador){
                ?>
                <option value=<?=$dadoscolaborador['id']?>><?=$dadoscolaborador['nome']?></option>
                 <?php
                }
                ?>
                </select>
                <input type="hidden" name = "id" value ="<?=$id?>">
                <input type="hidden" name = "acao" value ="editar">
                <input type="submit" value="Atualizar">
            </form>
            </div>
    <?php
        }else{
            header("Location: ./index.php?pagina=tarefa.php&acao=listar&mensagem=erro");
        }
        
    }elseif($acao=="visualizar"){   // Visualizar funcionando 
        if(isset($_GET["id"]) && !empty($_GET["id"])){
            $id = $_GET["id"];
            $row = $tarefa1->carregarTarefas($id);
            foreach($row as $dado)
            ?>
            <h2>Tarefa</h2>

            <div class="boxForm">
            <form action="controlerTarefa.php" method="post">
                <label for="nome">Nome Tarefa</label>
                <input type="text" id="nome" name="nome" value="<?=$dado['Tarefas'];?>">

                <label for="descricao">Descricao</label>
                <input type="text" id="descricao" name="descricao" value="<?=$dado['descricao'];?>">

                <label for="prazo">Prazo</label>
                <input type="text" id="prazo" name="prazo" value="<?=$dado['prazo'];?>">

                <label for="projeto">Projeto</label>
                <input type="text" id="projeto" name="projeto" value="<?=$dado['nome'];?>">
                
                <label for="colaborador">Responsavel</label>
                <input type="text" id="colaborador" name="colaborador" value="<?=$dado['colaborador'];?>">
                <br>
                <a class="button button2" href="index.php?pagina=colaborador.php&acao=listar">Voltar</a>
                
            </form>
            </div>
    <?php
        }else{
             header("Location: ./index.php?pagina=tarefa.php&acao=listar&mensagem=erro");
            }
                    
        }

    }    

    
?>