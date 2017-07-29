<?php require_once 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/animate.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">

	<meta name="description" content="CRUD utilizando PHP como lenguaje de servidor, AngularJS como lenguaje de lado cliente y MySLQ como base de datos">
	<meta name="keywords" content="AngularJS Insert Update Delete Using PHP MySQL, angularjs php mysql crud, add update delete in angularjs, php angularjs mysql insert delete update">
	<meta name="author" content="https://plus.google.com/+MuniAyothi/">
	<title>PHP AngularJS MySQL CRUD</title>

	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,200' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>
<body data-ng-app="AlumnosModule" data-ng-controller="AlumnosController" data-ng-init="init()">
	<input type="hidden" id="base_path" value="<?php echo BASE_PATH; ?>"/>


	<div class="container">

		<div class="clearfix"></div>
		<h2 class="title text-center"> AngularJS PHP MySQL</h2>

		<div class="row mt80">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 animated fadeInDown">
				<div class="alert alert-danger text-center alert-failure-div" role="alert" style="display: none">
					<p></p>
				</div>
				<div class="alert alert-success text-center alert-success-div" role="alert" style="display: none">
					<p></p>
				</div>
				<form novalidate name="userForm" >
					<div class="form-group">
						<label for="exampleInputEmail1">Nombre</label>
						<input data-ng-minlength="3" required type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" data-ng-model='tempUser.nombre'>
						<span class="help-block error" data-ng-show="userForm.nombre.$invalid && userForm.nombre.$dirty">
							{{getError(userForm.nombre.$error, 'nombre')}}
						</span>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Correo electronico</label>
						<input data-ng-minlength="3" required type="correo" class="form-control" id="correo" name="correo" placeholder="Correo electronico" data-ng-model='tempUser.correo'>
						<span class="help-block error" data-ng-show="userForm.correo.$invalid && userForm.correo.$dirty">
							{{getError(userForm.correo.$error, 'correo')}}
						</span>
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Carrera</label>
						<input data-ng-minlength="3" required type="text" class="form-control" id="carrera" name="carrera" placeholder="Carrera" data-ng-model='tempUser.carrera'>
						<span class="help-block error" data-ng-show="userForm.carrera.$invalid && userForm.carrera.$dirty">
							{{getError(userForm.carrera.$error, 'carrera')}}
						</span>
					</div>
					<div class="form-group">
						<label for="exampleInputFile">Semestre</label>
						<input data-ng-minlength="3" required type="text" class="form-control" id="semestre" name="semestre" placeholder="Semestre" data-ng-model='tempUser.semestre'>
						<span class="help-block error" data-ng-show="userForm.semestre.$invalid && userForm.semestre.$dirty">
							{{getError(userForm.semestre.$error, 'semestre')}}
						</span>
					</div>
					<!-- <input type="hidden" data-ng-model='tempUser.id'>  -->
					<div class="text-center">
						<button ng-disabled="userForm.$invalid" data-loading-text="Registrando alumno..." ng-hide="tempUser.id" type="submit" class="btn btn-save" data-ng-click="agregar_alumno()">Registrar Alumno</button>
						<button ng-disabled="userForm.$invalid" data-loading-text="Actualizando alumno..." ng-hide="!tempUser.id" type="submit" class="btn btn-save" data-ng-click="actualiza_alumno()">Actualizar Alumno</button>
					</div>

				</form>
			</div>

			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 animated fadeInUp">
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<th width="5%">#</th>
								<th width="20%">Nombre</th>
								<th width="20%">Correo</th>
								<th width="20%">Carrera</th>
								<th width="15%">Semestre</th>
								<th width="20%">Opciones</th>
							</tr>
						</thead>
						<tbody>
							<tr data-ng-repeat="alumno in post.users | orderBy : 'id'">
								<th scope="row">{{alumno.id}}</th>
								<td> {{alumno.nombre}} </td>
								<td> {{alumno.correo}} </td>
								<td> {{alumno.carrera}} </td>
								<td> {{alumno.semestre}} </td>
								<td> <span data-ng-click="editar_alumno(alumno)"> Editar</span> | <span data-ng-click="eliminar_alumno(alumno)">Eliminar</span> </td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>


	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="js/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
	<script src="js/angular.js"></script>
	<script src="js/controlador_angular.js"></script>
</body>
</html>
