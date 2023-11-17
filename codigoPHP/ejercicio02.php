<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../webroot/css/style.css">
    <link rel="icon" type="image/x-icon" href="../webroot/image/flora.png">
    <title>Rebeca Sánchez Pérez</title>
</head>

<body>
    <header>
        <a href="../../index.html"><img id="logo" src="../webroot/image/logo.png" alt="Logo"></a>
        <h1>Ejercicio 2</h1>
    </header>
    <main>
        <h2>Mostrar el contenido de la tabla Departamento y el número de registros</h2>
        <?php
            /*
             * @author Rebeca Sánchez Pérez
             * @version 1.4
             * @since 15/11/2023
             */
        
            // DECLARACION E INICIALIZACION DE VARIABLES
            // Se incuye la libreria de configuracion de bases de datos que almacena las constantes de la conexion
            require_once '../config/confDB.php';
            
            // Se realiza el ejercicio con una consulta preparada
            try {
                // Se instancia un objeto tipo PDO que establece la conexion a la base de datos con el usuario especificado
                $miDB = new PDO('mysql:host='.IPMYSQL.'; dbname='.NOMBREDB,USUARIO,PASSWORD);
                // Se preparan las consultas
                $consulta = $miDB->prepare('select * from T02_Departamento');
                // Se ejecuta la consulta
                $consulta->execute();
                // Se almacena el numero de filas afectadas
                $count = $consulta->rowCount();
                // Se crea una tabla para imprimir las tuplas
                echo('<div class="ejercicio"><h2>Con prepare() y execute():</h2><table class="ej16"><tr><th>Codigo</th><th>Descripcion</th><th>Fecha de alta</th><th>Volumen</th><th>Fecha de baja</th></tr>');
                
                // Se recorre cada fila, es decir, cada departamento
                while($oDepartamento = $consulta->fetchObject()){// TAMBIEN SE PUEDE REALIZAR CON fetch(PDO::FETCH_OBJ)
                    echo('<tr>');
                    echo('<td>'.$oDepartamento->T02_CodDepartamento.'</td>');
                    echo('<td>'.$oDepartamento->T02_DescDepartamento.'</td>');
                    echo('<td>'.$oDepartamento->T02_FechaCreacionDepartamento.'</td>');
                    echo('<td>'.$oDepartamento->T02_VolumenDeNegocio.'</td>');
                    echo('<td>'.$oDepartamento->T02_FechaBajaDepartamento.'</td>');
                    echo('</tr>');
                }
                echo('</table>');
                echo('</div><div class="ejercicio">');
                // Se muestra por pantalla el numero de tuplas  de la tabla departamentos
                echo('Numero total de registros: <b>'.$count.'</b>');
                echo('</div>');
                
                // Se cierra la conexion con la base de datos
                unset($miDB);
            } catch (PDOException $exception) {
                // Si aparecen errores, se muestra por pantalla el error
                echo('<div class="ejercicio"><span class="error">❌ Ha fallado la conexion: '. $exception->getMessage().'</span></div>');
            }
            
            // Se realiza el ejercicio con un execute query
            try {
                // Se instancia un objeto tipo PDO que establece la conexion a la base de datos con el usuario especificado
                $miDB = new PDO('mysql:host='.IPMYSQL.'; dbname='.NOMBREDB,USUARIO,PASSWORD);
                // Se almacena el resultado de la consulta
                $resultadoConsulta = $miDB->query('select * from T02_Departamento');
                // Se almacena el numero de filas afectadas
                $count2 = $resultadoConsulta->rowCount();
                // Se crea una tabla para imprimir las tuplas
                echo('<div class="ejercicio"><h2>Con query():</h2><table class="ej16"><tr><th>Codigo</th><th>Descripcion</th><th>Fecha de alta</th><th>Volumen</th><th>Fecha de baja</th></tr>');
                
                // Se recorre cada fila, es decir, cada departamento
                while($oDepartamento2 = $resultadoConsulta->fetchObject()){
                    echo('<tr>');
                    echo('<td>'.$oDepartamento2->T02_CodDepartamento.'</td>');
                    echo('<td>'.$oDepartamento2->T02_DescDepartamento.'</td>');
                    echo('<td>'.$oDepartamento2->T02_FechaCreacionDepartamento.'</td>');
                    echo('<td>'.$oDepartamento2->T02_VolumenDeNegocio.'</td>');
                    echo('<td>'.$oDepartamento2->T02_FechaBajaDepartamento.'</td>');
                    echo('</tr>');
                }
                echo('</table>');
                echo('</div><div class="ejercicio">');
                // Se muestra por pantalla el numero de tuplas de la tabla departamentos
                echo('Numero total de registros: <b>'.$count2.'</b>');
                echo('</div>');
                
                // Se cierra la conexion con la base de datos
                unset($miDB);
            } catch (PDOException $exception) {
                // Si aparecen errores, se muestra por pantalla el error
                echo('<div class="ejercicio"><span class="error">❌ Ha fallado la conexion: '. $exception->getMessage().'</span></div>');
            }
        ?>
    </main>
    <footer>
        <div id="derechos">2023-2024 © Todos los derechos reservados: <a href="../../index.html">Rebeca Sánchez Pérez</a></div>
        <div id="fotos">
            <a href="https://github.com/Ebenclaw" target="_blank"><img id="git" src="../webroot/image/GitHub.png" alt="GitHub"></a>
            <a href="http://ieslossauces.centros.educa.jcyl.es/sitio/" target="_blank"><img id="sauces" src="../webroot/image/sauces.png" alt="Sauces"></a>
            <a href="../indexProyectoTema4.php"><img id="home" src="../webroot/image/home.png" alt="Inicio"></a>
    </footer>
</body>

</html>

