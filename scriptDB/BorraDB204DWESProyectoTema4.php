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
    
    // Consulta de borrado de la base de datos
    $sql1 = <<< SQL
        drop database if exists dbs12302420;
    SQL;
    // Consulta de borrado del usuario
    $sql2 = <<< SQL
        drop user if exists 'dbu1704580'@'%';
    SQL;
    
    // Se preparan las consultas
    $consulta1 = $miDB->prepare($sql1);
    $consulta2 = $miDB->prepare($sql2);
    // Se ejecutan las consultas
    $consulta1->execute();
    $consulta2->execute();
    
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