<?php
  /*
  Clase para realizar manejar los servicios post que traeran y enviaran data a la BD
  */

  require_once 'config.php';

  if (isset($_POST['type']) && !empty($_POST['type']) ) {
    # code...
    $type = $_POST['type'];

    switch ($type) {
      case "guardar_alumno":
        guardar_alumno($mysqli);
        break;
      case "eliminar_alumno":
        eliminar_alumno($mysqli, $_POST['id']);
        break;
      case "obtenerAlumnos":
        obtenerAlumnos($mysqli);
        break;
      default:
        invalidRequest();
        break;
    }
  } else {
    invalidRequest();
  }


  /*
    Esta funcion maneja todo lo correspondido a agregar y modificar alumnos
  */

  function guardar_alumno($mysqli) {
    try {
      $data = array();
      $nombre = $mysqli->real_escape_string(isset( $_POST['alumno']['nombre'] ) ? $_POST['alumno']['nombre'] : '' );
      $correo = $mysqli->real_escape_string(isset( $_POST['alumno']['correo'] ) ? $_POST['alumno']['correo'] : '');
      $carrera = $mysqli->real_escape_string(isset( $_POST['alumno']['carrera'] ) ? $_POST['alumno']['carrera'] : '');
      $semestre = $mysqli->real_escape_string(isset( $_POST['alumno']['semestre'] ) ? $_POST['alumno']['semestre'] : '');
      $id_alumno = $mysqli->real_escape_string(isset( $_POST['alumno']['id'] ) ? $_POST['alumno']['id'] : '');

      if ($nombre == '' || $correo == '' || $carrera == '' || $semestre == '' ) {
        throw new Exception("Campos requeridos no han sido completados, por favor antes de enviar favor de llenarlos");
      }

      if (empty($id_alumno)) {
        $query = "INSERT INTO alumnos (`id`, `nombre`, `correo`, `carrera`, `semestre`) VALUES (NULL, '$nombre', '$correo', '$carrera', '$semestre')";
      } else {
        $query = "UPDATE alumnos SET `nombre` = '$nombre', `correo` = '$correo', `carrera` = '$carrera', `semestre` = '$semestre' WHERE `id` = $id_alumno";
      }

      if ( $mysqli->query( $query ) ) {
        $data['success'] = true;
        if (!empty($id_alumno)) {
          $data['message'] = 'Alumno actualizado exitosamente';
        } else {
          $data['message'] = 'Alumno registrado exitosamente';
        }

        if (empty($id_alumno)) {
          $data['id'] = (int) $mysqli->insert_id;
        } else {
          $data['id'] = (int) $id_alumno;
        }
      } else {
        throw new Exception( $mysqli->sqlstate.' - '. $mysqli->error );
      }

      $mysqli->close();
      echo json_encode($data);
      exit;

    } catch (Exception $e) {
      $data = array();
      $data['success'] = false;
      $data['message'] = $e->getMessage();
      echo json_encode($data);
      exit;
    }
  }

  /*
    Funcion para controlar el borrado de alumnos
  */

  function eliminar_alumno($mysqli, $id = '') {
    try {
      if (empty($id)) {
        throw new Exception( "Alumno invalido ");
      }

      $query = "DELETE FROM `alumnos` WHERE `id` = $id";

      if ($mysqli->query( $query )) {
        $data['success'] = true;
        $data['message'] = "Alumno eliminado correctamente";
        echo json_encode($data);
        exit;
      } else {
        throw new Exception( $mysqli->sqlstate.' - '. $mysqli->error );
      }
    } catch (Exception $e) {
      $data = array();
      $data['success'] = false;
      $data['message'] = $e->getMessage();
      echo json_encode($data);
      exit;
    }
  }

  /*
    Obtener los alumnos enlistados
  */
  function obtenerAlumnos($mysqli){
    try {
      $query = "SELECT * FROM `alumnos` ORDER BY id asc";
      $result = $mysqli->query($query);
      $data = array();
      while ($row = $result->fetch_assoc()) {
        $row['id'] = (int) $row['id'];
        $data['data'][] = $row;
      }
      $data['success'] = true;
      echo json_encode($data);
      exit;
    } catch (Exception $e) {
      $data = array();
      $data['success'] = false;
      $data['message'] = $e->getMessage();
      echo json_encode($data);
      exit;
    }
  }


  function invalidRequest() {
    $data = array();
    $data['success'] = false;
    $data['message'] = "Solicitud invalida";
    echo json_encode($data);
    exit;
  }
?>
