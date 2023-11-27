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
            /*
             * @author Rebeca Sánchez Pérez
             * @version 1.2
             * @since 06/11/2023
             */
        
            // DECLARACION E INICIALIZACION DE VARIABLES
            // La constante USUARIO almacena el nombre del usuario de la base de datos
            define('USUARIO', 'user204DWESProyectoTema4');
            // La constante PASSWORD almacena la contraseña del usuario de la base de datos
            define('PASSWORD', 'P@ssw0rd');
            // La constante IPMYSQL almacena la ip del servidor donde se encuentra la base de datos
            define('IPMYSQL', '192.168.20.19');
            // La constante NOMBREDB almacena el nombre de la base de datos
            define('NOMBREDB', 'DB204DWESProyectoTema4');
            // La variable $attributes almacena los artibutos que se pueden mostrar de una base de datos
            // No se incluyen "PERSISTENT", "PREFETCH" y "TIMEOUT"
            $attributesPDO = ['AUTOCOMMIT', 'ERRMODE', 'CASE', 'CLIENT_VERSION', 'CONNECTION_STATUS',
            'ORACLE_NULLS', 'SERVER_INFO', 'SERVER_VERSION'];
            
            try {
                // Se instancia un objeto tipo PDO que establece la conexion a la base de datos con el usuario especificado
                $miDB = new PDO('mysql:host='.IPMYSQL.'; dbname='.NOMBREDB,USUARIO,PASSWORD);
                echo('<div class="ejercicio">Se ha establecido la conexion a la base de datos correctamente ✅ <br>');
                foreach ($attributesPDO as $valor) {
                    echo('PDO::<u>ATTR_'.$valor.'</u> => <b>'.$miDB->getAttribute(constant("PDO::ATTR_$valor"))."</b><br>");
                }
                echo('</div>');
                // Se cierra la conexion con la base de datos
                unset($miDB);
            } catch (PDOException $exception) {
                // Si aparecen errores, se muestra por pantalla el error
                echo('<div class="ejercicio"><span class="error">❌ Ha fallado la conexion: '. $exception->getMessage().'</span></div>');
            } 
            
            // Este try catch esta programado para que salte el mensaje de error al poner la contraseña del usuario mal
            try {
                // Se instancia un objeto tipo PDO que establece la conexion a la base de datos con el usuario especificado pero con una contraseña incorrecta
                $miDB = new PDO('mysql:host='.IPMYSQL.'; dbname='.NOMBREDB,USUARIO,'paso');
                echo('<div class="ejercicio">Se ha establecido la conexion a la base de datos correctamente ✅');
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

