<?php
//conectar com banco dados
$conectar = mysql_connect('localhost','root','');
$banco    = mysql_select_db('livraria');

if (isset($_POST['Gravar']))
{
//receber as variaveis do HTML
    $codigo       = $_POST['codigo'];
    $titulo           = $_POST['titulo'];
    $nrpaginas           = $_POST['nrpaginas'];
    $ano       = $_POST['ano'];
    $codautor           = $_POST['codautor'];
    $codcategoria           = $_POST['codcategoria'];
    $codeditora       = $_POST['codeditora'];
    $resenha           = $_POST['resenha'];
    $preco           = $_POST['preco'];
    $fotocapa1       = $_FILES['fotocapa1'];
    $fotocapa2           = $_FILES['fotocapa2'];
    
            $diretorio = "fotos/";

            $extensao1 = strtolower(substr($_FILES['fotocapa1']['name'], -4));
            $novo_nome1 = md5(time().$extensao1);
            move_uploaded_file($_FILES['fotocapa1']['tmp_name'], $diretorio.$novo_nome1);
        
            $extensao2 = strtolower(substr($_FILES['fotocapa2']['name'], -6));
            $novo_nome2 = md5(time().$extensao2);
            move_uploaded_file($_FILES['fotocapa2']['tmp_name'], $diretorio.$novo_nome2);
        
           $sql = mysql_query("INSERT INTO livro (codigo,titulo,nrpaginas,ano,codautor,codcategoria,codeditora,resenha,preco,fotocapa1,fotocapa2)
                        values ('$codigo','$titulo','$nrpaginas','$ano','$codautor','$codcategoria','$codeditora','$resenha','$preco','$novo_nome1','$novo_nome2')");
        
           $resultado = mysql_query($sql);
        
           if ($resultado)
                {echo " Falha ao gravar os dados informados";}
           else
                {echo " Dados informados cadastrados com sucesso";}
        }

        if(isset($_POST['Alterar']))
        {
            $codigo = $_POST['codigo'];
            $titulo = $_POST['titulo'];
            $nrpaginas = $_POST['nrpaginas'];
            $ano = $_POST['ano'];
            $codautor = $_POST['codautor'];
            $codcategoria = $_POST['codcategoria'];
            $codeditora = $_POST['codeditora'];
            $resenha = $_POST['resenha'];
            $preco = $_POST['preco'];
            $fotocapa1 = $_FILES['fotocapa1'];
            $fotocapa2 = $_FILES['fotocapa2'];
         
            $sql = "update livro set titulo = '$titulo', nrpaginas = '$nrpaginas', ano = '$ano', codautor = '$codautor', codcategoria = '$codcategoria', codeditora = '$codeditora', resenha = '$resenha', preco = '$preco' where codigo = '$codigo'";
         
            $resultado = mysql_query($sql);
         
            if($resultado == TRUE)
            {
                echo "Dados alterados com sucesso.";
            }
            else
            {
                echo "Erro ao alterar os dados!";
            }
        }
if (isset($_POST['Excluir']))
{
    //receber as variaveis do HTML
    $codigo       = $_POST['codigo'];
    $titulo           = $_POST['titulo'];
    $nrpaginas           = $_POST['nrpaginas'];
    $ano       = $_POST['ano'];
    $codautor           = $_POST['codautor'];
    $codcategoria           = $_POST['codcategoria'];
    $codeditora       = $_POST['codeditora'];
    $resenha           = $_POST['resenha'];
    $preco           = $_POST['preco'];
    $fotocapa1       = $_FILES['fotocapa1'];
    $fotocapa2           = $_FILES['fotocapa2'];

    $sql = "delete from livro
            where codigo = '$codigo'";

    $resultado = mysql_query($sql);

    if ($resultado == TRUE)
    {
        echo "Dados deletados";
    }
    else
    {
        echo "Erro ao excluir dados";
    }
}
if (isset($_POST['Pesquisar']))
{
    $sql = "select * from livro";

    $resultado = mysql_query($sql);

    if (mysql_num_rows($resultado) == 0)
    {
        echo "Dados não encontrados";
    }
    else
    {
        echo "<b>"."Pesquisa por Livros: "."</b><br>";
        while($dados = mysql_fetch_array($resultado))
    
        echo "Codigo :".$dados['codigo']."<br>",
             "Titulo   :".$dados['titulo']."<br>",
             "Numero de Paginas   :".$dados['nrpaginas']."<br>",
             "Ano                 :".$dados['ano']."<br>",
             "CodAutor            :".$dados['codautor']."<br>",
             "CodCategoria        :".$dados['codcategoria']."<br>",
             "CodEditora          :".$dados['codeditora']."<br>",
             "Resenha             :".$dados['resenha']."<br>",
             "Preco               :".$dados['preco']."<br>",
             '<img src="fotos/'.$dados['fotocapa1'].'"height="200" width="200" />'."  ",
             '<img src="fotos/'.$dados['fotocapa2'].'"height="200" width="200" />'."<br><br>  ";
             
    }
}
?>