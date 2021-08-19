<?php
include "../conexion.php";

if(!empty($_POST))
{
  if($_POST['idusuario'] ==1){
    header("location: lista_usuarios.php");
    exit;
    
  }
 $idusuario = $_POST['idusuario'];

 //$query_delete = mysqli_query($conection,"DELETE FROM usuario  WHERE idusuario = $idusuario ");
 $query_delete = mysqli_query($conection,"UPDATE usuario SET estatus = 0 WHERE idusuario = $idusuario ");
 if($query_delete){
	 header("location: lista_usuarios.php");	 
 }else{
	 echo "Error al Eliminar";

 }
}

if(empty($_REQUEST['id']) || $_REQUEST['id'] ==1)
{
header ("location: lista_usuarios.php");

}else{

$idusuario = $_REQUEST['id'];

$query = mysqli_query($conection,"SELECT u.nombre,u.usuario,r.rol
                                         FROM usuario u
                                         INNER JOIN
                                         rol r
                                         ON u.rol = r.idrol
                                         WHERE u.idusuario = $idusuario" );

$resul = mysqli_num_rows($query);

if($resul > 0){

while ($data = mysqli_fetch_array($query)){

$nombre = $data['nombre'];
$usuario = $data['usuario'];
$rol = $data['rol'];
   }
}else{
	header ("location: lista_usuarios.php");

}


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/script.php"; ?>
	<title>Eliminar Usuario</title>
</head>
<body>
<?php include "includes/header.php"; ?>

	<section id="container">
    
    <div class="card mx-auto mt-4 p-3 mb-2 bg-light text-dark" style="width: 30rem;">
    <h4>Confirmar Accion</h4>
    <hr>
  <div class="card-body ">
  <div class="alert alert-danger" role="alert">
  <h6>Esta seguro que quiere eliminar<span class="badge badge-danger"><?php echo $usuario; ?></span>?</h6>
</div>

    <p class="h5">Nombre: <span class="badge badge-light"><?php echo $nombre; ?></span></p>
    
    <p class="h5">Tipo Usuario:<span class="badge badge-light">  <?php echo $rol; ?></span></p>
	<form method="post" action="" class="mt-1 form-control card">
		<input type="hidden" name="idusuario" value="<?php echo $idusuario;?>">
	<div class="row">
    <div class="col">
	<a class="btn btn-success form-control btn-sm" href="lista_usuarios.php" >Cancelar</a>
    </div>
    <div class="col">
	<input class="btn btn-primary form-control btn-sm" type="submit" value="Aceptar">
    </div>
  </div>
</form>
  </div>
</div>
	</section>
	<?php include "includes/footer.php"; ?>

</body>
</html>