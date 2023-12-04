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
            /**
             * @author Carlos García Cachón
             * @version 1.0
             * @since 20/11/2023
             */
            // Utilizamos el bloque 'try'
            try {
                require_once '../config/confDBMySQLi.php';
                // Establecemos la conexión por medio de PDO
                $mysqli = new mysqli(DSN, USERNAME, PASSWORD, DBNAME);
                echo ("<span style='color:green;'>CONEXIÓN EXITOSA POR MYSQLLI</span><br><br>"); // Mensaje si la conexión es exitosa

                // Preparamos y ejecutamos la consulta SQL
                $consulta = "SELECT * FROM T02_Departamento";
                $resultadoConsultaPreparada = $mysqli->prepare($consulta);
                $resultadoConsultaPreparada->execute();

                // Obtenemos el resultado
                $resultado = $resultadoConsultaPreparada->get_result();

                // Creamos una tabla en la que mostraremos la tabla de la BD
                echo('<div class="ejercicio"><h2>Con prepare() y execute():</h2><table class="ej16"><tr><th>Codigo</th><th>Descripcion</th><th>Fecha de alta</th><th>Volumen</th><th>Fecha de baja</th></tr>');

                /* Recorremos todos los valores de la tabla, columna por columna */
                while ($oDepartamento = $resultado->fetch_object()) {
                    echo ("<tr>");
                    echo ("<td>".$oDepartamento->T02_CodDepartamento."</td>");
                    echo ("<td>".$oDepartamento->T02_DescDepartamento."</td>");
                    echo ("<td>".$oDepartamento->T02_FechaCreacionDepartamento."</td>");
                    echo ("<td>".$oDepartamento->T02_VolumenDeNegocio."</td>");
                    echo ("<td>".$oDepartamento->T02_FechaBajaDepartamento."</td>");
                    echo ("</tr>");
                }

                echo ("</table>");
                echo('</div><div class="ejercicio">');
                /* Usamos la función 'num_rows' para obtener el número de filas afectadas por la consulta */
                $numeroDeRegistrosResultado = $resultado->num_rows;
                // Y mostramos el número de registros
                echo('Numero total de registros: <b>'.$numeroDeRegistrosResultado.'</b>');
                echo('</div>');

            } catch (Exception $ex) { // Si falla el 'try', mostramos el mensaje seguido del error correspondiente
                echo ("<div style='color:red;' class='fs-4 text'>ERROR DE CONEXIÓN</div> ".$ex->getMessage());
            } finally {
                // Comprobamos si no hay ningún error de conexión con la BD
                if ($mysqli && $mysqli->connect_errno === 0) {
                    $mysqli->close(); // Cerramos la conexión
                }
            }
        ?>
    </main>
    <footer>
        <div id="derechos">2023-2024 © Todos los derechos reservados: <a href="../../index.html">Rebeca Sánchez Pérez</a></div>
        <div id="fotos">
            <a href="https://github.com/Ebenclaw/204DWESProyectoTema4" target="_blank"><img id="git" src="../webroot/image/GitHub.png" alt="GitHub"></a>
            <a href="http://ieslossauces.centros.educa.jcyl.es/sitio/" target="_blank"><img id="sauces" src="../webroot/image/sauces.png" alt="Sauces"></a>
            <a href="../indexProyectoTema4.php"><img id="home" src="../webroot/image/home.png" alt="Inicio"></a>
    </footer>
</body>

</html>

