<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="webroot/css/style.css">
    <link rel="icon" type="image/x-icon" href="/webroot/image/flora.png">
    <title>Rebeca Sánchez Pérez</title>
</head>

<body>
    <header>
        <a href="../index.html"><img id="logo" src="webroot/image/logo.png" alt="Logo"></a>
        <h1>Tema 4 - Técnicas de acceso a datos en PHP</h1>
    </header>
    <main>
        <table class="tablaIndex script">
            <caption>Ficheros de configuracion</caption>
            <tr>
                <td>Configuracion de la base de datos PDO</td>
                <td><a href="mostrarcodigo/muestraConfPDO.php"><img src="webroot/image/ojo.png" alt="ojo"/></a></td>
            </tr>
            <tr>
                <td>Configuracion de la base de datos MySQLi</td>
                <td><a href="mostrarcodigo/muestraConfMySQLi.php"><img src="webroot/image/ojo.png" alt="ojo"/></a></td>
            </tr>
        </table>
        <table class="tablaIndex script">
            <caption>Scripts DB</caption>
            <tr>
                <td>Script creación de base de datos y usuario</td>
                <td><a href="mostrarcodigo/muestraCrear.php"><img src="webroot/image/ojo.png" alt="ojo"/></a></td>
            </tr>
            <tr>
                <td>Script carga inicial de base de datos</td>
                <td><a href="mostrarcodigo/muestraCarga.php"><img src="webroot/image/ojo.png" alt="ojo"/></a></td>
            </tr>
            <tr>
                <td>Script borrado de base de datos y usuario</td>
                <td><a href="mostrarcodigo/muestraBorra.php"><img src="webroot/image/ojo.png" alt="ojo"/></a></td>
            </tr>
        </table>
        <table class="tablaIndex">
            <caption>Ejercicios</caption>
            <tr>
                <th>Enunciado</th>
                <th colspan="2">PDO</th>
                <th colspan="2">MySQLi</th>
            </tr>
            <tr>
                <td>1. Conexión a la base de datos con la cuenta usuario y tratamiento de errores</td>
                <td><a href="codigoPHP/ejercicio01PDO.php"><img src="webroot/image/play.png" alt="play"/></a></td>
                <td><a href="mostrarcodigo/muestraEjercicio01PDO.php"><img src="webroot/image/ojo.png" alt="ojo"/></a></td>
                <td><a href="codigoPHP/ejercicio01MySQLi.php"><img src="webroot/image/play.png" alt="play"/></a></td>
                <td><a href="mostrarcodigo/muestraEjercicio01MySQLi.php"><img src="webroot/image/ojo.png" alt="ojo"/></a></td>
            </tr>
            <tr>
                <td>2. Mostrar el contenido de la tabla Departamento y el número de registros</td>
                <td><a href="codigoPHP/ejercicio02.php"><img src="webroot/image/play.png" alt="play"/></a></td>
                <td><a href="mostrarcodigo/muestraEjercicio02.php"><img src="webroot/image/ojo.png" alt="ojo"/></a></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>3. Formulario para añadir un departamento a la tabla Departamento con validación de entrada y control de errores</td>
                <td><a href="codigoPHP/ejercicio03.php"><img src="webroot/image/play.png" alt="play"/></a></td>
                <td><a href="mostrarcodigo/muestraEjercicio03.php"><img src="webroot/image/ojo.png" alt="ojo"/></a></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>4. Formulario de búsqueda de departamentos por descripción (por una parte del campo DescDepartamento, si el usuario no pone nada deben aparecer todos los departamentos)</td>
                <td><a href="codigoPHP/ejercicio04.php"><img src="webroot/image/play.png" alt="play"/></a></td>
                <td><a href="mostrarcodigo/muestraEjercicio04.php"><img src="webroot/image/ojo.png" alt="ojo"/></a></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>5. Pagina web que añade tres registros a nuestra tabla Departamento utilizando tres instrucciones insert y una transacción, de tal forma que se añadan los tres registros o no se añada ninguno</td>
                <td><a href="codigoPHP/ejercicio05.php"><img src="webroot/image/play.png" alt="play"/></a></td>
                <td><a href="mostrarcodigo/muestraEjercicio05.php"><img src="webroot/image/ojo.png" alt="ojo"/></a></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>6. Pagina web que cargue registros en la tabla Departamento desde un array departamentosnuevos utilizando una consulta preparada</td>
                <td><a href="codigoPHP/ejercicio06.php"><img src="webroot/image/play.png" alt="play"/></a></td>
                <td><a href="mostrarcodigo/muestraEjercicio06.php"><img src="webroot/image/ojo.png" alt="ojo"/></a></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>7.1. JSON: Página web que toma datos (código y descripción) de un fichero json y los añade a la tabla Departamento de nuestra base de datos. (IMPORTAR). El fichero importado se encuentra en el directorio .../tmp/ del servidor</td>
                <td><a href="codigoPHP/ejercicio07JSON.php"><img src="webroot/image/play.png" alt="play"/></a></td>
                <td><a href="mostrarcodigo/muestraEjercicio07JSON.php"><img src="webroot/image/ojo.png" alt="ojo"/></a></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>8.1. JSON: Página web que toma datos (código y descripción) de la tabla Departamento y guarda en un fichero departamento.json. (COPIA DE SEGURIDAD / EXPORTAR). El fichero exportado se encuentra en el directorio .../tmp/ del servidor</td>
                <td><a href="codigoPHP/ejercicio08JSON.php"><img src="webroot/image/play.png" alt="play"/></a></td>
                <td><a href="mostrarcodigo/muestraEjercicio08JSON.php"><img src="webroot/image/ojo.png" alt="ojo"/></a></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </main>
    <footer>
        <div id="derechos">2023-2024 © Todos los derechos reservados: <a href="../index.html">Rebeca Sánchez Pérez</a></div>
        <div id="fotos">
            <a href="https://github.com/Ebenclaw/204DWESProyectoTema4" target="_blank"><img id="git" src="webroot/image/GitHub.png" alt="GitHub"></a>
            <a href="http://ieslossauces.centros.educa.jcyl.es/sitio/" target="_blank"><img id="sauces" src="webroot/image/sauces.png" alt="Sauces"></a>
            <a href="../204DWESProyectoDWES/indexProyectoDWES.php"><img id="home" src="webroot/image/home.png" alt="Inicio"></a>
        </div>
    </footer>
</body>

</html>



