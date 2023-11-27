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
        <h1>Ejercicio 1</h1>
    </header>
    <main>
        <h2>Conexión a la base de datos con la cuenta usuario y tratamiento de errores</h2>
        <?php
            /**
             * @author Carlos García Cachón, Rebeca Sánchez Pérez
             * @version 1.0
             * @since 27/11/2023
             */
            // Incluyo el fichero que guarda la cofiguración de la conexión por MySQLLi
            require_once '../config/confDBMySQLi.php';

            try {
                $mysqli = new mysqli(DSN, USERNAME, PASSWORD, DBNAME);

                echo('<div class="ejercicio">Se ha establecido la conexion a la base de datos correctamente ✅ <br><u>HOST_INFO</u> => <b>' . $mysqli->host_info .'</b></div>');
            } catch (mysqli_sql_exception $ex) {
                echo('<div class="ejercicio"><span class="error">❌ Ha fallado la conexion: '. $mysqli->connect_errno  . $mysqli->connect_error. ")</div>");
            } finally {
                // Cerramos la conexión si está abierta
                if ($mysqli && $mysqli->connect_errno === 0) {
                    $mysqli->close();
                }
            }

            try {
                $mysqli = new mysqli(DSN, USERNAME, 'PASSWORD', DBNAME);

                echo('<div class="ejercicio">Se ha establecido la conexion a la base de datos correctamente ✅ <br><u>HOST_INFO</u> => <b>' . $mysqli->host_info .'</b></div>');
            } catch (Exception $ex) {
                echo('<div class="ejercicio"><span class="error">❌ Ha fallado la conexion: '. $mysqli->connect_errno  . $mysqli->connect_error. "</span></div>");
            } finally {
                // Comprobamos si no hay ningun error de conexión con la BD
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

