<?php 

class DataBase {


    public static function connect($host = 'localhost', $user = 'root',$pass = '', $db = 'teats'){


            $con = new mysqli($host, $user, $pass, $db);

            if($con == false){
                echo 'No se ha realizado la conexion con la database';
            }
            else{
                return $con;
            }



    }




}



?>