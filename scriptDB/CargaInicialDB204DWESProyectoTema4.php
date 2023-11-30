<?php
/*
 * @author Rebeca Sánchez Pérez
 * @version 1.1
 * @since 29/11/2023
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