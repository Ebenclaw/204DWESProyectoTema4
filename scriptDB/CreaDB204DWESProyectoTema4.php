<?php
/*
 * @author Rebeca Sánchez Pérez
 * @version 1.1
 * @since 29/11/2023
 */

// DECLARACION E INICIALIZACION DE VARIABLES
// Se incuye la libreria de configuracion de bases de datos que almacena las constantes de la conexion
require_once '../config/confDBPDO.php';

// Se realiza el ejercicio con una consulta preparada
try {
    // Se instancia un objeto tipo PDO que establece la conexion a la base de datos con el usuario especificado
    $miDB = new PDO('mysql:host=' . IPMYSQL . '; dbname=' . NOMBREDB, USUARIO, PASSWORD);
    
    // Consulta de creacion y uso de la base de datos
    $sql1 = <<< SQL
        create database dbs12302420;
        use dbs12302420;
    SQL;
    // Consulta de creacion de la tabla departamento
    $sql2 = <<< SQL
        create table if not exists T02_Departamento(
            T02_CodDepartamento varchar(3) primary key,
            T02_DescDepartamento varchar(255),
            T02_FechaCreacionDepartamento datetime,
            T02_VolumenDeNegocio float,
            T02_FechaBajaDepartamento datetime default null)engine=innodb;
    SQL;
    // Consulta de creacion del usuario
    $sql3 = <<< SQL
        create user 'dbu1704580'@'%' identified by 'daw2_Sauces';
        grant all privileges on dbs12302420.* to 'dbu1704580'@'%';
    SQL;
    
    // Se preparan las consultas
    $consulta1 = $miDB->prepare($sql1);
    $consulta2 = $miDB->prepare($sql2);
    $consulta3 = $miDB->prepare($sql3);
    // Se ejecutan las consultas
    $consulta1->execute();
    $consulta2->execute();
    $consulta3->execute();
    
//    // Se crea una tabla para imprimir las tuplas
//    echo('<div class="ejercicio"><h2>Con prepare() y execute():</h2><table class="ej16"><tr><th>Codigo</th><th>Descripcion</th><th>Fecha de alta</th><th>Volumen</th><th>Fecha de baja</th></tr>');
//
//    // Se recorre cada fila, es decir, cada departamento
//    while ($oDepartamento = $consulta->fetchObject()) {// TAMBIEN SE PUEDE REALIZAR CON fetch(PDO::FETCH_OBJ)
//        echo('<tr>');
//        echo('<td>' . $oDepartamento->T02_CodDepartamento . '</td>');
//        echo('<td>' . $oDepartamento->T02_DescDepartamento . '</td>');
//        echo('<td>' . $oDepartamento->T02_FechaCreacionDepartamento . '</td>');
//        echo('<td>' . $oDepartamento->T02_VolumenDeNegocio . '</td>');
//        echo('<td>' . $oDepartamento->T02_FechaBajaDepartamento . '</td>');
//        echo('</tr>');
//    }
//    echo('</table>');
//    echo('</div><div class="ejercicio">');
//    // Se muestra por pantalla el numero de tuplas  de la tabla departamentos
//    echo('Numero total de registros: <b>' . $count . '</b>');
//    echo('</div>');
} catch (PDOException $exception) {
    // Si aparecen errores, se muestra por pantalla el error
    echo('<div class="ejercicio"><span class="error">❌ Ha fallado la conexion: ' . $exception->getMessage() . '</span></div>');
} finally{
    // Se cierra la conexion con la base de datos
    unset($miDB);
}
?>