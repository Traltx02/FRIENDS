<?php


	$con = new mysqli("localhost", "root", "", "loginval");
	
	if ($con->connect_errno){
		
		echo "No hay conexion:  (" . $con->connect_errno ." ) ". $con->connect_errno;
		
	}

		$usu= $_POST['username'];
		$pas= $_POST['password'];
		
	
	//Registrar
	if(isset($_POST['registrar'])){
		
		//variable que guarla a contraseña encriptada
		$pass_fuerte = password_hash($pas, PASSWORD_DEFAULT);
		$query_registrar = "INSERT INTO usuarios(usuario, contraseña) VALUES ('$usu', '$pass_fuerte')";
	
		//si el registro fue exitoso	
		if (mysqli_query($con, $query_registrar)){
			
			echo "Usuario registrado correctamente : $usu";

			header("location:starsesion.html");
			
		}else{
			
			echo "El usuario no no fue insertado, Error: . $query_registrar. <br> ". mysql_error($con);
		}		
	}
	
	//Ingresar registro
	
	if(isset($_POST['btn_login'])){
		
		//buscar el usuario ingresado
	
		$query_usuario = mysqli_query($con, "SELECT * FROM usuarios WHERE usuario = '$usu'");
		//si el usuario se encuentra en la bd, esta ocupando una fila
		$nr = mysqli_num_rows($query_usuario); 	
		//almacenamos las columnas del usuario encontrado
		$buscarpass = mysqli_fetch_array($query_usuario);
		
		//verificar la contraseña, columna contraseña de la bd
		if(($nr==1) && (password_verify($pas, $buscarpass['contraseña']))){
		
			echo "Bienvenido: $usu";
			
		
				header("location:chat.html");

		}else{
			
			echo "Contraseña incorrecta";	
		}
		
	}
	
	

?>