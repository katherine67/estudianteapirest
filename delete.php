<?php

    header  ("Access-Control-Allow-Origin: *");
    header  ("Access-Control-Allow-Headers: access");
    header  ("Access-Control-Allow-Methods: DELETE");
    header  ("Content-Type: application/json; Charset=UFT-8");
    header  ("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With");

    require 'config.php';
    $db_connection = new database();
    $conn = $db_connection->dbconnection();

    $data = json_decode(file_get_contents("php://input"));

    if(isset($data->id)){
        $msg['message'] = '';
        $post_id = $data -> id;

        $check_post =       "SELECT * FROM `estudiante` WHERE id=:post_id";
        $check_post_stmt =  $conn -> prepare($check_post);
        $check_post_stmt -> bindValue(':post_id',$post_id,PDO::PARAM_INT);
        $check_post_stmt -> execute();

        if($check_post_stmt->rowCount() > 0){
            $delete_post =      "DELETE FROM `estudiante` WHERE id=:post_id";
            $delete_post_stmt = $conn->prepare($delete_post);
            $delete_post_stmt ->bindValue(':post_id',$post_id,PDO::PARAM_INT);

            if($delete_post_stmt->execute()){
                $msg['message'] = 'Estudiante Eliminado Correctamente';
            }else{
                $msg['message'] = 'Estudiante no eliminado';
            }
        }else{
            $msg['message'] = 'ID invalido';
        }
    echo json_encode($msg);
    }
?>