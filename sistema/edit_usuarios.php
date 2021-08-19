<?php
include "../conexion.php";
if(!empty($_POST))
{
    $alert='';
    if(empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) ||  empty($_POST['rol']))
    {
        $alert='<p class="msg_error">Todos los campos son obligatorios</p>';
    }else{
         
        $idUsuario = $_POST['idUsuario'];
        $nombre = $_POST['nombre'];
        $email = $_POST['correo'];
        $user = $_POST['usuario'];
        $clave = md5($_POST['clave']);
        $rol = $_POST['rol']; 
           
        $query = mysqli_query($conection, "SELECT * FROM usuario
                                         WHERE (usuario = '$user' AND idusuario != $idUsuario)
                                          OR (correo = '$email' AND idusuario != $idUsuario) ");
                                       

        $result = mysqli_fetch_array($query);
        

        if($result > 0){
            $alert='<p class="msg_error">El correo o el usuario ya existe.</p>';

        }else{

            if(empty($_POST['clave']))
{
      $sql_update = mysqli_query($conection,"UPDATE usuario
                                              SET nombre = '$nombre', correo='$email', usuario='$user',rol='$rol'
                                                WHERE idusuario = $idUsuario");

                                                      
}else{
$sql_update = mysqli_query($conection,"UPDATE usuario
                                              SET nombre = '$nombre', correo='$email', usuario='$user', clave='$clave',rol='$rol'
                                                WHERE idusuario = $idUsuario");
}                            

                if($sql_update){
                    $alert ='</div>
                    <div class="mt-1 alert alert-success" role="alert">
                      El usuario fue Actualizado!!
                    </div>';

                } else{
                    $alert ='</div>
                    <div class="alert alert-warning" role="alert">
                      Error al Actualizar
                    </div>';

                }
    }


    }
    

}

//MOSTRAR DATOS
if(empty($_GET['id']))
{
    header('location: lista_usuarios.php');
    
}
$iduser = $_GET['id'];

$sql= mysqli_query($conection,"SELECT u.idusuario, u.nombre, u.correo, u.usuario, (u.rol) as idrol, (r.rol) as rol 
                                   FROM usuario u 
                                INNER JOIN rol r
                                on u.rol = r.idrol
                                WHERE idusuario = $iduser");


$result_sql = mysqli_num_rows($sql);

if($result_sql == 0){
    header('location: lista_usuarios.php');

}else{
    $option = '';
    while ($data = mysqli_fetch_array($sql)) {
        # code...
        $iduser = $data['idusuario'];
        $nombre = $data['nombre'];
        $correo = $data['correo'];
        $usuario = $data['usuario'];
        $idrol = $data['idrol'];
        $rol = $data['rol'];

        if($idrol == 1){
         $option = '<option value="'.$idrol.'" select>'.$rol.'</option>';     
        }else if($idrol == 2){
        $option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
        }else if($idrol == 3){
        $option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
        }

        
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include "includes/script.php"; ?>

	<meta charset="UTF-8">
	
	<title>Actualizar Usuario</title>
</head>
<body>
<?php include "includes/header.php"; ?>

	<section id="container">
		
<div class=" mx-auto mt-4" style="width: 30rem;">
<div class="">
    <div class=""><h5 class="text-primary">Actualizar Usuarios</h5></div>
    <div role="alert"><?php echo isset($alert) ? $alert :''; ?></div>
    <form action=""  method="post" class="form-group card mt-1">
    <input type="hidden" name="idUsuario" value="<?php echo $iduser; ?>">
        
        <label for="nombre" class="font-weight-bold text-lg-left">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control form-control-sm text-muted" placeholder="Nombre completo" value="<?php echo $nombre;?>">
        <label for="correo" class="font-weight-bold text-lg-left">Correo</label>
        <input type="email" name="correo" id="correo" class="form-control form-control-sm " placeholder="Correo Electronico" value="<?php echo $correo;?>">
        <label for="nombre" class="font-weight-bold text-lg-left">Usuario</label>
        <input type="text" name="usuario" id="usuario" class="form-control form-control-sm " placeholder="Usuario"value="<?php echo $usuario;?>" >
        <label for="clave" class="font-weight-bold text-lg-left">Clave</label>
        <input type="password" name="clave" id="clave" class="form-control form-control-sm "  placeholder="Clave de usuario">
        <label for="rol" class="font-weight-bold text-lg-left">Tipo de Usuario</label>

        <?php
        $query_rol = mysqli_query($conection,"SELECT * FROM rol");
        $result_rol = mysqli_num_rows($query_rol);
        ?>

        <select name="rol" id="rol" class="form-control form-control-sm notItemOne" aria-label=".form-select-sm example">
           <?php
            echo $option;
           if($result_rol > 0)
           {
               while ($rol = mysqli_fetch_array($query_rol)) {
                   # code...
                   ?>
                   <option value="<?php echo $idrol["rol"];?>"><?php echo $rol["rol"]?></option>
                   <?php
               }
           }
           
           ?>
</select>
<input type="submit" value="Actualizar Usuario" class="btn btn-primary btn-sm mt-1">
</form>

</div>
        </div>
    
	</section>
	<?php include "includes/footer.php"; ?>

</body>
</html>