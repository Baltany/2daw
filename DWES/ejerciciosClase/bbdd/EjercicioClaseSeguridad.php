<form action="" method="post">
    usuario: <input type="text" name="usu"> <br>
    password: <input type="password" name="pass"> <br>
    <input type="submit" name="entrar" value="Entrar">
</form>

<?php
if(isset($_POST['entrar'])){
    try{
        $connection = new mysqli("localhost","dwes","abc123.","empleados");
        /* Consulta NO PREPARADa
        $result = $connection -> query("SELECT * FROM datos WHERE usuario = BINARY '$_POST[usu]' AND password = BINARY '$_POST[pass]'");
        */

        // consulta preparada
        $stmt = $connection -> prepare("SELECT * FROM datos WHERE usuario = BINARY ? AND password = BINARY ?");
        $stmt -> bind_param('ss',$_POST['usu'],$_POST['pass']);
        $stmt -> execute();
        $result = $stmt -> get_result();

    }catch(mysqli_sql_exception $e){
        echo $e;
    }
    // es num_rows ya que el affected rows
    if($result->num_rows > 0 )
        echo "Has entrado";



}

?>