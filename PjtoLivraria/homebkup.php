<?php
$connect = mysql_connect('localhost','root','');
$db      = mysql_select_db('livraria');

session_start();

$status="";

if (isset($_POST['codigo']) && $_POST['codigo']!=""){
   $codigo = $_POST['codigo'];
   $resultado = mysql_query("SELECT descricao,preco,fotocapa1 FROM produto WHERE codigo = '$codigo'");
   $row = mysql_fetch_assoc($resultado);
   $descricao = $row['descricao'];
   $preco = $row['preco'];
   $foto1 = $row['fotocapa1'];

   $cartArray = array($codigo => array(
     'codigo' => $codigo, 
     'descricao' => $descricao,
     'preco' => $preco,
     'quantity' => 1,
     'foto' => $foto1
 ));

   if(empty($_SESSION["shopping_cart"])) {
     $_SESSION["shopping_cart"] = $cartArray;
     $status = "<div class='box'>Produto foi add ao carrinho !</div>";
     }
     else{
     $array_keys = array_keys($_SESSION["shopping_cart"]);
 
    if(in_array($codigo,$array_keys)) {
      $status = "<div class='box' style='color:red;'>
      Produto foi adicionado ao carrinho!</div>";
     }
     else {
     $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"],$cartArray);
     $status = "<div class='box'>Produto  foi add ao carrinho!</div>";
      }
 
      }

 }
 ?>

<?php
if(!empty($_SESSION["shopping_cart"])) 
     $cart_count = count(array_keys($_SESSION["shopping_cart"]));
?>
<div class="cart_div">
<a href="cart.php"><img src="css/carrinho.png" height=50 width=50/>Carrinho<span>
<?php echo $cart_count; ?></span></a>
</div>


<div style="clear:both;"></div>

<div class="message_box" style="margin:10px 0px;">
<?php echo $status; ?>
</div>




 
<HTML>
<HEAD>
<link rel="stylesheet" href="css/styles.css">
 <TITLE>Alexandria - Home</TITLE>
</HEAD>
<body>
     <hr>
    <form name="formulario" method="post" action="home.php">
       <img src="css/Logo.png" width=20% align="left">
       <div id="imga">
       <a href="usuario.html"><img src="css/Usuario.png" width=6% align="right"></a>
       </div>
       <br><br>
       <div id="titl">
       <h1>| Biblioteca |</h1>
       </div>
       <br><br>

       <div class="slider">
 
          <div class="slides">
 
          <input type="radio" name="radio-btn" id="radio1">
          <input type="radio" name="radio-btn" id="radio2">
          <input type="radio" name="radio-btn" id="radio3">
 
          <div class="slide first">
               <img src="css/banner1.jpg">
          </div>
 
          <div class="slide">
               <img src="css/banner2.jpg">
          </div>
 
          <div class="slide">
               <img src="css/banner3.jpg">
          </div>
 
          <div class="auto-navegacao">
               <div class="auto-btn1"></div>
               <div class="auto-btn2"></div>
               <div class="auto-btn3"></div>
          </div>
 
          </div>
 
          <div class="navegacao-manual">
               <label for="radio1" class="manual-btn"></label>
               <label for="radio2" class="manual-btn"></label>
               <label for="radio3" class="manual-btn"></label>
          </div>
 
     </div>
       
       <!------ pesquisar Categorias -------------->
       <div id="filter">
       <h2>Filtros:</h2>
       </div>
          <div id="select">
        <label for="">Categoria: </label>
        <select name="categoria">
        <option value="" selected="selected">Selecione...</option>
        </div>
 
        <?php
        $query = mysql_query("SELECT codigo, nome FROM categoria");
        while($categoria = mysql_fetch_array($query))
        {?>
        <option value="<?php echo $categoria['codigo']?>">
                       <?php echo $categoria['nome']   ?></option>
        <?php }
        ?>
        </select>
       
        <!------ pesquisar Classificacao -------------->
        
        <label for="">Editora: </label>
        <select name="editora">
        <option value="" selected="selected">Selecione...</option>
        
        <?php
        $query = mysql_query("SELECT codigo, nome FROM editora");
        while($tipo = mysql_fetch_array($query))
        {?>
        <option value="<?php echo $tipo['codigo']?>">
                       <?php echo $tipo['nome']   ?></option>
        <?php }
        ?>
        </select>
       
       <!------ pesquisar marcas -------------->
       
       <label for="">Autor: </label>
        <select name="autor">
        <option value="" selected="selected">Selecione...</option>
       
 
        <?php
        $query = mysql_query("SELECT codigo, nome , pais FROM autor");
        while($marca = mysql_fetch_array($query))
        {?>
        <option value="<?php echo $marca['codigo']?>">
                       <?php echo $marca['nome']   ?>
                       <?php echo $marca['pais']   ?></option>
        <?php }
        ?>
        </select>
        <div id="btnhome">
        <input  type="submit" name="pesquisar" value="Filtrar">
        </div>
    </form>
<br><br>
<?php
 
if (isset($_POST['pesquisar']))
{
//verifica que a op  o marca e modelo foi selecionada ou n o
$editora          = (empty($_POST['editora']))? 'null' : $_POST['editora'];
$categoria      = (empty($_POST['categoria']))? 'null' : $_POST['categoria'];
$autor  = (empty($_POST['autor']))? 'null' : $_POST['autor'];
 
//---------- pesquisar  marca escolhida ----------------
 
if (($editora <> 'null') and ($categoria == 'null') and ($autor == 'null'))
{
     $sql_produtos = "SELECT livro.codigo, livro.titulo, livro.nrpaginas, livro.ano, livro.codautor, livro.codcategoria, livro.codeditora, livro.resenha, livro.preco, livro.fotocapa1, livro.fotocapa2
                            FROM livro, editora, categoria, autor
                            WHERE livro.codeditora = editora.codigo
                            and livro.codcategoria = categoria.codigo
                            and livro.codautor = autor.codigo
                            and editora.codigo = $editora ";
                           
     $seleciona_produtos = mysql_query($sql_produtos);
}
 
//---------- pesquisar categoria escolhida ----------------
 
if (($editora == 'null') and ($categoria <> 'null') and ($autor == 'null'))
{
     $sql_produtos = "SELECT livro.codigo, livro.titulo, livro.nrpaginas, livro.ano, livro.codautor, livro.codcategoria, livro.codeditora, livro.resenha, livro.preco, livro.fotocapa1, livro.fotocapa2
                            FROM livro, editora, categoria, autor
                            WHERE livro.codeditora = editora.codigo
                            and livro.codcategoria = categoria.codigo
                            and livro.codautor = autor.codigo
                            and categoria.codigo = $categoria ";
                           
     $seleciona_produtos = mysql_query($sql_produtos);
}
 
//---------- pesquisar marca e categoria escolhida ----------------
 
//---------- pesquisar tipo escolhido ----------------
 
if (($editora == 'null') and ($categoria == 'null') and ($autor <> 'null'))
{
     $sql_produtos = "SELECT livro.codigo, livro.titulo, livro.nrpaginas, livro.ano, livro.codautor, livro.codcategoria, livro.codeditora, livro.resenha, livro.preco, livro.fotocapa1, livro.fotocapa2
                            FROM livro, editora, categoria, autor
                            WHERE livro.codeditora = editora.codigo
                            and livro.codcategoria = categoria.codigo
                            and livro.codautor = autor.codigo
                            and autor.codigo = $autor ";
                           
     $seleciona_produtos = mysql_query($sql_produtos);
}

if (($editora <> 'null') and ($categoria <> 'null') and ($autor == 'null'))
{
     $sql_produtos = "SELECT livro.codigo, livro.titulo, livro.nrpaginas, livro.ano, livro.codautor, livro.codcategoria, livro.codeditora, livro.resenha, livro.preco, livro.fotocapa1, livro.fotocapa2
                            FROM livro, editora, categoria, autor
                            WHERE livro.codeditora = editora.codigo
                            and livro.codcategoria = categoria.codigo
                            and livro.codautor = autor.codigo
                            and livro.codigo = $editora 
                            and categoria.codigo = $categoria";
                           
     $seleciona_produtos = mysql_query($sql_produtos);
}

if (($editora == 'null') and ($categoria <> 'null') and ($autor <> 'null'))
{
     $sql_produtos = "SELECT livro.codigo, livro.titulo, livro.nrpaginas, livro.ano, livro.codautor, livro.codcategoria, livro.codeditora, livro.resenha, livro.preco, livro.fotocapa1, livro.fotocapa2
                            FROM livro, editora, categoria, autor
                            WHERE livro.codeditora = editora.codigo
                            and livro.codcategoria = categoria.codigo
                            and livro.codautor = autor.codigo
                            and autor.codigo = $autor 
                            and categoria.codigo = $categoria";
                           
     $seleciona_produtos = mysql_query($sql_produtos);
}

if (($editora <> 'null') and ($categoria == 'null') and ($autor <> 'null'))
{
     $sql_produtos = "SELECT livro.codigo, livro.titulo, livro.nrpaginas, livro.ano, livro.codautor, livro.codcategoria, livro.codeditora, livro.resenha, livro.preco, livro.fotocapa1, livro.fotocapa2
                            FROM livro, editora, categoria, autor
                            WHERE livro.codeditora = editora.codigo
                            and livro.codcategoria = categoria.codigo
                            and livro.codautor = autor.codigo
                            and autor.codigo = $autor
                            and editora.codigo = $editora";
                           
     $seleciona_produtos = mysql_query($sql_produtos);
}

if (($editora <> 'null') and ($categoria <> 'null') and ($autor <> 'null'))
{
     $sql_produtos = "SELECT livro.codigo, livro.titulo, livro.nrpaginas, livro.ano, livro.codautor, livro.codcategoria, livro.codeditora, livro.resenha, livro.preco, livro.fotocapa1, livro.fotocapa2
                            FROM livro, editora, categoria, autor
                            WHERE livro.codeditora = editora.codigo
                            and livro.codcategoria = categoria.codigo
                            and livro.codautor = autor.codigo
                            and autor.codigo = $autor
                            and editora.codigo = $editora
                            and categoria.codigo = $categoria";
                           
     $seleciona_produtos = mysql_query($sql_produtos);
}
 
//---------- pesquisar marca e categoria e tipo escolhido ----------------
 
// colocar mais filtros ?????
 
 
 
//---------- mostrar as informa  es dos produtos  ----------------
if(mysql_num_rows($seleciona_produtos) == 0)
{
   echo '<h1>Desculpe, mas sua busca nao retornou resultados ... </h1>';
}
else
{
   echo "Resultado da pesquisa de Produtos: <br><br>";
   while ($dados = mysql_fetch_object($seleciona_produtos))
{
    echo "<form method='post' action=''>";
    echo "<input type='hidden' name='codigo' value='".$dados->codigo."' />";
    echo "Titulo: ".$dados->titulo."<br>";
    echo " / Numero de Paginas: ".$dados->nrpaginas."<br>";
    echo " / Ano: ".$dados->ano."<br>";
    echo " / Codigo Autor:".$dados->codautor."<br>";
    echo " / Codigo Categoria:".$dados->codcategoria."<br>";
    echo " / Codigo Editora:".$dados->codeditora."<br>";
    echo " / Resenha:".$dados->resenha."<br>";
    echo " / Preco : R$".$dados->preco." <br><br>";
    echo '<img src="fotos/'.$dados->fotocapa1.'" width="200" /><br><br> ';
    echo '<img src="fotos/'.$dados->fotocapa2.'" width="200" /><br><br>';
    echo "<button type='submit' class='buy'>COMPRAR</button>";
    echo "</form><br><br>";
}
   }
   
}
?>


<script src="banner.js"></script>
</body>
 
</HTML>
 