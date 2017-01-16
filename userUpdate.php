<?php
require_once(dirname(__FILE__) . '/../../config.php');
global $DB, $USER, $CFG;

//###########################PREGUNTAR TEMA DE LAS MAYUSCULAS##########################################
if (($gestor = fopen("Usuarios.csv", "r")) !== FALSE) {
   $cont = 0;
   while (($datos = fgetcsv($gestor, 2000, ",")) !== FALSE) {

      
      if ($datos[0] !== 'username') {
         $sql_step = "SELECT u.id, u.firstname, u.lastname, u.institution, u.department, u.phone1, u.phone2 FROM {user} u WHERE u.username IN (?)"; 
         $info = $DB->get_records_sql($sql_step, array($datos[0]));
            echo 'DATA ACTUAL<br>';
            echo "<pre>";
            print_r($info);
            echo "</pre>";
            
            if ($info == array()) {
               echo '############<br>'.$datos[0]. ' doesnt exist<br>###########<br>';
               continue;
            }
               
            $updateu = new stdClass();
            $updateu->id = key($info);
            //$updateu->username = $datos[0];
            $updateu->firstname = $datos[1];
            $updateu->lastname = $datos[2];
            $updateu->institution = $datos[3];
            $updateu->department = $datos[4];
            $updateu->phone1 = $datos[5];
            $updateu->phone2 = $datos[6];
            $DB->update_record('user',  $updateu);
                        //echo key($info) . '<br>'; 

            

            $sql_step2 = "SELECT u.id, u.firstname, u.lastname, u.institution, u.department, u.phone1, u.phone2 FROM {user} u WHERE u.username IN (?)"; 
            $info2 = $DB->get_records_sql($sql_step2, array($datos[0]));
            echo 'DATA ACTUALIZADA<br>';
            echo "<pre>";
            print_r($info2);
            echo "</pre>"; 
            echo '########################################################################<br>';
            echo '########################################################################<br>';
      }   
      
   }
   
}else{
   echo '<script>console.log("No existe archivo csv")</script>';
   die();
}
