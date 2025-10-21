<?php
//conectar com banco dados
$conectar = mysql_connect('localhost','root','');
$banco    = mysql_select_db('livraria');

if (isset($_POST['Gravar']))
{
//receber as variaveis do HTML
    $codigo       = $_POST['codigo'];
    $nome           = $_POST['nome'];
    $pais           = $_POST['pais'];

    $sql = "insert into autor (codigo,nome,pais)
            values ('$codigo','$nome','$pais')";

    $resultado = mysql_query($sql);
    
    if ($resultado == TRUE)
    {
         echo "Dados gravados com sucesso.";
    }
    else
    {
         echo "Erro ao gravar os dados.";
    }
}
if (isset($_POST['Alterar']))
{
    //receber as variaveis do HTML
    $pais = $_POST['pais'];
    $nome = $_POST['nome'];
    $codigo = $_POST['codigo'];

    $sql = "update autor set nome = '$nome',pais = '$pais' where codigo = '$codigo'";

    $resultado = mysql_query($sql);

    if ($resultado == TRUE)
    {
        echo "Dados alterados com sucesso.";
    }
    else
    {
        echo "Erro ao alterar os dados";
    }
}
if (isset($_POST['Excluir']))
{
    //receber as variaveis do HTML
    $pais = $_POST['pais'];
    $nome = $_POST['nome'];
    $codigo = $_POST['codigo'];

    $sql = "delete from autor
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
    $sql = "select * from autor";

    $resultado = mysql_query($sql);

    if (mysql_num_rows($resultado) == 0)
    {
        echo "Dados não encontrados";
    }
    else
    {
        echo "<b>"."Pesquisa por Autores: "."</b><br>";
        while($dados = mysql_fetch_array($resultado))
    
        echo "Codigo :".$dados['codigo']."<br>",
             "Nome   :".$dados['nome']."<br>",
             "Pais   :".$dados['pais']."<br><br>";
    }
}
?>