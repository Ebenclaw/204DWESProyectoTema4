<?php
/*
 * @author Rebeca Sánchez Pérez
 * @version 1.2
 * @since 01/12/2023
 */

// DECLARACION E INICIALIZACION DE VARIABLES
// Se definen las constantes de la configuracion de la base de datos
define('IPMYSQL', 'db5014806751.hosting-data.io');
define('NOMBREDB', 'dbs12302420');
define('USUARIO', 'dbu1704580');
define('PASSWORD', 'daw2_Sauces');

// Se realiza el ejercicio con una consulta preparada
try {
    // Se instancia un objeto tipo PDO que establece la conexion a la base de datos con el usuario especificado
    $miDB = new PDO('mysql:host=' . IPMYSQL . '; dbname=' . NOMBREDB, USUARIO, PASSWORD);
    
    // Consulta de insercion de datos en la tabla departamento
    $sql1 = <<< SQL
        insert into T02_Departamento values ("DAW","Desarrollo de aplicaciones web",now(),50.50,null),
        ("SMR","Sistemas microinformarticos y redes",now(),1.50,null),
        ("PRE","Proyectos de edificacion",now(),150,null),
        ("DAM","Desarrollo de aplicaciones multiplataforma",now(),10.25,null),
        ("ASI","Administracion de sistemas informaticos en red",now(),0.10,null);
    SQL;
    
    // Se prepara la consulta
    $consulta1 = $miDB->prepare($sql1);
    // Se ejecuta la consulta
    $consulta1->execute();
   
    // Se muestra el mensaje de exito
    echo('Se han insertado los datos a la tabla "T02_Departamento" correctamente ✅');
} catch (PDOException $exception) {
    // Si aparecen errores, se muestra por pantalla el error
    echo('<div class="ejercicio"><span class="error">❌ Ha fallado la conexion: ' . $exception->getMessage() . '</span></div>');
} finally{
    // Se cierra la conexion con la base de datos
    unset($miDB);
}
?>