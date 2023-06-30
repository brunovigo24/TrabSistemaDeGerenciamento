<?php

require_once("./Model/Colaborador.php");
$colab1 = new Colaborador();

?>
<div>
<h2>Gestão de Colaboradores</h2>
<a href="index.php?pagina=colaborador.php&acao=listar"><button class="button button1">Listar Todos</button></a>
<a href="index.php?pagina=colaborador.php&acao=inserir"><button class="button button2">Adicionar Colaborador</button></a>

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
        Ocorreu um erro na operação com o colaborador, reveja os dados e tente novamente mais tarde. Obrigado!
        </div>
        <?php
    }
}

if(isset($_GET["acao"]) && !empty($_GET["acao"])){

    $acao = $_GET["acao"];

    if($acao=="listar"){
        $resultado = $colab1->listar();
        if (count($resultado)) {
        ?>
            <table id="customers">
                <tr>
                    <th>ITEM</th>
                    <th>NOME</th>
                    <th>CARGO</th>
                    <th>AÇÃO</th>
                </tr>
            <?php 
                $i=1; 
                foreach($resultado as $row) {
                    $id = $row["id"];
                ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?=$row["nome"]?></td>
                    <td><?=$row["cargo"]?></td>
                    <td>
                    <a href="index.php?pagina=colaborador.php&acao=visualizar&id=<?=$id?>"><button class="button button4">Visualizar</button></a>
                    <a href="index.php?pagina=colaborador.php&acao=alterar&id=<?=$id?>"><button class="button button2">Alterar</button></a>
                    <a href="index.php?pagina=controlerColaborador.php&acao=excluir&id=<?=$id?>"><button class="button button3">Excluir</button></a>
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
    <h2>Adicionar Colaborador</h2>

    <div class="boxForm">
    <form action="controlerColaborador.php" method="post" enctype="multipart/form-data">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" placeholder="Informe o nome do colaborador">

        <label for="cpf">CPF</label>
        <input type="text" id="cpf" name="cpf" placeholder="Informe o seu CPF sem pontos e traços.">

        <label for="cargo">Cargo</label>
        <select id="cargo" name="cargo">
        <option value="Gerente">Gerente</option>
        <option value="Desenvolvedor">Desenvolvedor</option>
        <option value="Suporte">Suporte</option>
        </select>
        <input type="file" name="arquivo">
        <input type="hidden" name="acao" value="inserir">
        <input type="submit" value="Adicionar">
    </form>
    </div>

    <?php
    }elseif($acao=="alterar"){   // Alterar funcionando 
        if(isset($_GET["id"]) && !empty($_GET["id"])){
            $id = $_GET["id"];
            $row = $colab1->carregarColaborador($id);
            foreach($row as $dado)
        ?>
            <h2>Alterar Colaborador</h2>

            <div class="boxForm">
            <form action="controlerColaborador.php" method="post" enctype="multipart/form-data">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" value="<?=$dado['nome'];?>">

                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" value="<?=$dado['cpf'];?>">

                <label for="cargo">Cargo</label>
                <select id="cargo" name="cargo">
                <option value="Gerente" <?php if($dado['cargo'] == "Gerente") echo "selected"?>>Gerente</option>
                <option value="Desenvolvedor" <?php if($dado['cargo'] == "Desenvolvedor") echo "selected"?>>Desenvolvedor</option>
                <option value="Suporte" <?php if($dado['cargo'] == "Suporte") echo "selected"?>>Suporte</option>
                </select>
                <img width="150" src="<?=$dado['arquivo'];?>">
                <input type="file" name="arquivo">
                <input type="hidden" name = "id" value ="<?=$id?>">
                <input type="hidden" name = "acao" value ="editar">
                <input type="submit" value="Atualizar">
            </form>
            </div>
    <?php
        }else{
            header("Location: ./index.php?pagina=colaborador.php&acao=listar&mensagem=erro");
        }
    }elseif($acao=="visualizar"){     // Visualizar funcionando 
        if(isset($_GET["id"]) && !empty($_GET["id"])){
            $id = $_GET["id"];
            $row = $colab1->carregarColaborador($id);
            foreach($row as $dado)
            ?>
            <h2>Colaborador</h2>

            <div class="boxForm">
            <form action="controlerColaborador.php" method="post">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" value="<?=$dado['nome'];?>">

                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" value="<?=$dado['cpf'];?>">

                <label for="cargo">Cargo</label>
                <input type="text" id="cargo" name="cargo" value="<?=$dado['cargo'];?>">

            </form>
            <img width="150" src="<?=$dado['arquivo'];?>">
            <br>
            <a class="button button2" href="index.php?pagina=colaborador.php&acao=listar">voltar</a>
            </div>
        <?php
        }else{
            header("Location: ./index.php?pagina=colaborador.php&acao=listar&mensagem=erro");{

            }
        }
        

    }
}

?>
