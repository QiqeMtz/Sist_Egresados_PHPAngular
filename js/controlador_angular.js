$AlumnosModule = angular.module('AlumnosModule', []);

$AlumnosModule.controller('AlumnosController', function($scope, $http) {
  $scope.post = {};
  $scope.post.users = [];
  $scope.tempUser = {};
  $scope.editMode = false;
  $scope.index = '';

  var url = 'ajax.php';

  $scope.guardar_alumno = function(){
    $http({
      method: 'post',
      url: url,
      data: $.param({'alumno' : $scope.tempUser, 'type' : 'guardar_alumno'}),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).
    success(function(data, status, headers, config) {
      if (data.success) {
        if ($scope.editMode) {
          $scope.post.users[$scope.index].id = data.id;
          $scope.post.users[$scope.index].nombre = $scope.tempUser.nombre;
          $scope.post.users[$scope.index].correo = $scope.tempUser.correo;
          $scope.post.users[$scope.index].carrera = $scope.tempUser.carrera;
          $scope.post.users[$scope.index].semestre = $scope.tempUser.semestre;
        } else {
          $scope.post.users.push({
            id : data.id,
            nombre : $scope.tempUser.nombre,
            correo : $scope.tempUser.correo,
            carrera : $scope.tempUser.carrera,
            semestre : $scope.tempUser.semestre
          });
        }
        $scope.messageSuccess(data.message);
        $scope.userForm.$setPristine();
        $scope.tempUser = {};

      } else {
        $scope.messageFailure(data.message);
      }
    }).
    error(function(data, status, headers, config) {

    });
    jQuery('.btn-save').button('reset');
  }

  $scope.agregar_alumno = function(){
    jQuery('.btn-save').button('loading');
    $scope.guardar_alumno();
    $scope.editMode = false;
    $scope.index = '';
  }

  $scope.actualiza_alumno = function(){
    $('.btn-save').button('loading');
    $scope.guardar_alumno();
  }

  $scope.editar_alumno = function(alumno){
		$scope.tempUser = {
			id: alumno.id,
			nombre : alumno.nombre,
			correo : alumno.correo,
			carrera : alumno.carrera,
			semestre : alumno.semestre
		};
		$scope.editMode = true;
		$scope.index = $scope.post.users.indexOf(alumno);
	}

  $scope.eliminar_alumno = function(alumno){
		var r = confirm("Seguro que quiere eliminar este alumno?!");
		if (r == true) {
			$http({
		      method: 'post',
		      url: url,
		      data: $.param({ 'id' : alumno.id, 'type' : 'eliminar_alumno' }),
		      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		    }).
		    success(function(data, status, headers, config) {
		    	if(data.success){
		    		var index = $scope.post.users.indexOf(alumno);
		    		$scope.post.users.splice(index, 1);
		    	}else{
		    		$scope.messageFailure(data.message);
		    	}
		    }).
		    error(function(data, status, headers, config) {
		    	//$scope.messageFailure(data.message);
		    });
		}
	}

      $scope.init = function(){
	    $http({
	      method: 'post',
	      url: url,
	      data: $.param({ 'type' : 'obtenerAlumnos' }),
	      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
	    }).
	    success(function(data, status, headers, config) {
	    	if(data.success && !angular.isUndefined(data.data) ){
	    		$scope.post.users = data.data;
	    	}else{
	    		$scope.messageFailure(data.message);
	    	}
	    }).
	    error(function(data, status, headers, config) {
	    	//$scope.messageFailure(data.message);
	    });
	}

  $scope.messageFailure = function (msg){
		jQuery('.alert-failure-div > p').html(msg);
		jQuery('.alert-failure-div').show();
		jQuery('.alert-failure-div').delay(5000).slideUp(function(){
			jQuery('.alert-failure-div > p').html('');
		});
	}

	$scope.messageSuccess = function (msg){
		jQuery('.alert-success-div > p').html(msg);
		jQuery('.alert-success-div').show();
		jQuery('.alert-success-div').delay(5000).slideUp(function(){
			jQuery('.alert-success-div > p').html('');
		});
	}


	$scope.getError = function(error, name){
		if(angular.isDefined(error)){
			if(error.required && name == 'name'){
				return "Please enter name";
			}else if(error.email && name == 'email'){
				return "Please enter valid email";
			}else if(error.required && name == 'company_name'){
				return "Please enter company name";
			}else if(error.required && name == 'designation'){
				return "Please enter designation";
			}else if(error.required && name == 'email'){
				return "Please enter email";
			}else if(error.minlength && name == 'name'){
				return "Name must be 3 characters long";
			}else if(error.minlength && name == 'company_name'){
				return "Company name must be 3 characters long";
			}else if(error.minlength && name == 'designation'){
				return "Designation must be 3 characters long";
			}
		}
	}

});
