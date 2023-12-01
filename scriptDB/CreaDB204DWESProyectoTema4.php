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
    
    // Consulta de creacion de la tabla departamento
    $sql1 = <<< SQL
        create table if not exists dbs12302420.T02_Departamento(
            T02_CodDepartamento varchar(3) primary key,
            T02_DescDepartamento varchar(255),
            T02_FechaCreacionDepartamento datetime,
            T02_VolumenDeNegocio float,
            T02_FechaBajaDepartamento datetime default null)engine=innodb;
    SQL;
    
    // Se preparan las consultas
    $consulta1 = $miDB->prepare($sql1);
    // Se ejecutan las consultas
    $consulta1->execute();
    
    // Se muestra el mensaje de exito
    echo('Se ha creado la tabla "T02_Departamento" correctamente ✅');
} catch (PDOException $exception) {
    // Si aparecen errores, se muestra por pantalla el error
    echo('<div class="ejercicio"><span class="error">❌ Ha fallado la conexion: ' . $exception->getMessage() . '</span></div>');
} finally{
    // Se cierra la conexion con la base de datos
    unset($miDB);
}
?>