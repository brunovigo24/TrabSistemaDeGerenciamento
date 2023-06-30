<?php

require_once("./Model/Projeto.php");
require_once("./Model/Colaborador.php");
$projeto = new Projeto();
$colaborador = new Colaborador();

?>
<div>
<h2>Gestão de Projetos</h2>
<a href="index.php?pagina=projeto.php&acao=listar"><button class="button button1">Listar Todos</button></a>
<a href="index.php?pagina=projeto.php&acao=inserir"><button class="button button2">Novo Projeto</button></a>

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
        Ocorreu um erro na operação com o projeto, reveja os dados e tente novamente mais tarde. Obrigado!
        </div>
        <?php
    }
}

if(isset($_GET["acao"]) && !empty($_GET["acao"])){

    $acao = $_GET["acao"];

    if($acao=="listar"){
        $resultado = $projeto->listarProjetosStatus(1);
    
        if (count($resultado)) {
        ?>
            <table id="customers">
                <tr>
                    <th>ITEM</th>
                    <th>PROJETO</th>
                    <th>GERENTE</th>
                    <th>INICIO</th>
                    <th>AÇÃO</th>
                </tr>
            <?php  
                $i=1;
                foreach($resultado as $row) {
                    $id = $row["id"];
                ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?=$row["Projeto"]?></td>
                    <td><?=$row["nome"]?></td>
                    <td><?php
                        $data = new DateTime($row["dataInicio"]);
                        echo $data->format('d/m/Y'); 
                    ?></td>
                    <td>
                    <a href="index.php?pagina=projeto.php&acao=visualizar&id=<?=$id?>"><button class="button button4">Visualizar</button></a>
                    <a href="index.php?pagina=projeto.php&acao=alterar&id=<?=$id?>"><button class="button button2">Alterar</button></a>
                    <a href="index.php?pagina=controlerProjeto.php&acao=excluir&id=<?=$id?>"><button class="button button3">Excluir</button></a>
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
    }elseif($acao=="inserir"){   //Inserir funcionando 
    ?>
    <h2>Novo Projeto</h2>

    <div class="boxForm">
    <form action="controlerProjeto.php" method="post">
        <label for="nome">Projeto</label>
        <input type="text" id="nome" name="nome" placeholder="Informe o nome do Projeto">

        <label for="descricao">Descricao</label>
        <input type="text" id="descricao" name="descricao" placeholder="Informe a descricao do projeto.">

        <label for="responsavel">Gerente</label>
        <select id="responsavel" name="responsavel">
        <?php
            $colaboradorGerente = 
            $colaborador->carregarColaboradorGerente();
            foreach($colaboradorGerente as $rowColaborador){
            ?>
                <option value=<?=$rowColaborador['id']?>>
                <?=$rowColaborador['nome']?></option>
            <?php
            }
        ?>
        </select>
        <label for="dataInicio">Data de Início</label>
        <input type="date" id="dataInicio" name="dataInicio">

        <input type="hidden" name="acao" value="inserir">
        <input type="hidden" name="status" value="1">
        <input type="submit" value="Adicionar">
    </form>
    </div>

    <?php
    }elseif($acao=="alterar"){   // Alterar funcionando 
        if(isset($_GET["id"]) && !empty($_GET["id"])){
            $id = $_GET["id"];
            $row = $projeto->carregarProjetos($id);
            foreach($row as $dado)
        ?>
            <h2>Alterar Projeto</h2>

            <div class="boxForm">
            <form action="controlerProjeto.php" method="post">
                <label for="nome">Projeto</label>
                <input type="text" id="nome" name="nome" value="<?=$dado['Projeto'];?>">

                <label for="descricao">Descricao</label>
                <input type="text" id="descricao" name="descricao" value="<?=$dado['descricao'];?>">

                <label for="responsavel">Gerente</label>
                <select id="responsavel" name="responsavel">
                <?php
                $colaboradorGerente = 
                $colaborador->carregarColaboradorGerente();
                foreach($colaboradorGerente as $rowColaborador){
                ?>
                    <option value=<?=$rowColaborador['id']?> <?php if($dado['nome'] == $rowColaborador["nome"]) echo "selected"; ?>>
                    <?=$rowColaborador['nome']?></option>
                <?php
                }
            ?>
                </select>
                <label for="dataInicio">Data de Inicio</label>
                <input type="date" id="dataInicio" name="dataInicio" value="<?=$dado['dataInicio'];?>">
               
                <input type="hidden" name = "id" value ="<?=$id?>">
                <input type="hidden" name = "acao" value ="editar">
                <input type="hidden" name = "status" value ="1">
                <input type="submit" value="Atualizar">
            </form>
            </div>
        
    <?php
        }else{
        header("Location: ./index.php?pagina=projeto.php&acao=listar&mensagem=erro");
    } 


    }elseif($acao=="visualizar"){    // Visualizar funcionando 
        if(isset($_GET["id"]) && !empty($_GET["id"])){
            $id = $_GET["id"];
            $row = $projeto->carregarProjetos($id);
            foreach($row as $dado)
                ?>
                <h2>Projeto</h2>
    
                <div class="boxForm">
                <form action="controlerProjeto.php" method="post">
                <label for="nome">Projeto</label>
                <input type="text" id="nome" name="nome" value="<?=$dado['Projeto'];?>">

                <label for="descrição">Descrição</label>
                <input type="text" id="descricao" name="descricao" value="<?=$dado['descricao'];?>">

                <label for="responsavel">Gerente</label>
                <input type="text" id="responsavel" name="responsavel" value="<?=$dado['nome'];?>">

                <label for="dataInicio">Data de Início</label>
                <input type="date" id="dataInicio" name="dataInicio" value="<?=$dado['dataInicio'];?>">
                <hr>
                <h3>TAREFAS DO PROJETO</h3>
                <table width="100%" id='customers'>
                <tr>
                    <th width="10%">ITEM</th> 
                    <th>TAREFA</th>
                    <th width="10%"> </th>  
                </tr>
                <?php

                $row_tarefa = $projeto->carregarTarefas($dado['id']);
                foreach($row_tarefa as $dado_tarefa){
                ?>
                <tr>
                    <td><?= $dado_tarefa['id']?> </td> 
                    <td><?= $dado_tarefa['nome']?></td>
                    <td><a class="button button2" href="index.php?pagina=tarefa.php&acao=visualizar&id=<?= $dado_tarefa['id']?>">ver</a></td>  
                </tr>
                <?php
                }
                ?>s
                </table>
                <br>
                <a class="button button2" href="index.php?pagina=colaborador.php&acao=listar">Voltar</a>
    
                </form>
                </div>
    <?php
        }else{
            header("Location: ./index.php?pagina=projeto.php&acao=listar&mensagem=erro");
        }
            
        }
    }

?>