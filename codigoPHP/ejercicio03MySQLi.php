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
            <h1>Ejercicio 3</h1>
        </header>
        <main>
            <h2>Formulario para añadir un departamento a la tabla Departamento con validación de entrada y control de errores</h2>

            <?php
            /**
             * @author Carlos García Cachón
             * @version 1.0 
             * @since 20/11/2023
             */
            // Incluyo la libreria de validación para comprobar los campos
            require_once '../core/231018libreriaValidacion.php';
            // Incluyo el fichero que guarda la cofiguración de la conexión por MySQLLi
            require_once '../config/confDBMySQLi.php';

            // Declaración de constantes por OBLIGATORIEDAD
            define('OPCIONAL', 0);
            define('OBLIGATORIO', 1);

            // Declaración de los limites para el metodo comprobar FLOAT
            define('TAM_MAX_FLOAT', PHP_FLOAT_MAX);
            define('TAM_MIN_FLOAT', PHP_FLOAT_MIN);

            // Variable DateTime
            $fechaYHoraActualCreacion = new DateTime('now', new DateTimeZone('Europe/Madrid'));
            // Y formateo la variable '$fechaYHoraActualCreacion' para que aparezca en el input 'YYYY-mm-dd'
            $fechaYHoraActualCreacionFormateada = $fechaYHoraActualCreacion->format('Y-m-d');

            // Declaración de variables de estructura para validar la ENTRADA de RESPUESTAS o ERRORES
            // Valores por defecto
            $entradaOK = true;

            $aRespuestas = [
                'CodDepartamento' => "",
                'DescDepartamento' => "",
                'FechaCreacionDepartamento' => "",
                'VolumenDeNegocio' => "",
                'FechaBajaDepartamento' => ""
            ];

            $aErrores = [
                'CodDepartamento' => "",
                'DescDepartamento' => "",
                'FechaCreacionDepartamento' => "",
                'VolumenDeNegocio' => "",
                'FechaBajaDepartamento' => ""
            ];
            //En el siguiente if pregunto si el '$_REQUEST' recupero el valor 'enviar' que enviamos al pulsar el boton de enviar del formulario.
            if (isset($_REQUEST['enviar'])) {
                /*
                 * Ahora inicializo cada 'key' del ARRAY utilizando las funciónes de la clase de 'validacionFormularios' , la cuál 
                 * comprueba el valor recibido (en este caso el que recibe la variable '$_REQUEST') y devuelve 'null' si el valor es correcto,
                 * o un mensaje de error personalizado por cada función dependiendo de lo que validemos.
                 */
                //Introducimos valores en el array $aErrores si ocurre un error
                $aErrores['CodDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['CodDepartamento'], 3, 3, OBLIGATORIO);

                // Ahora validamos que el codigo introducido no exista en la BD, haciendo una consulta 
                if ($aErrores['CodDepartamento'] == null) {
                    try {
                        // CONEXION BASE DE DATOS
                        // Iniciamos la conexión con la BD
                        $mysqli = new mysqli(DSN, USERNAME, PASSWORD, DBNAME);

                        // Utilizamos 'real_escape_string()' para escapar y citar el valor de $_REQUEST['CodDepartamento']
                        $codDepartamento = $mysqli->real_escape_string($_REQUEST['CodDepartamento']);

                        // Utilizamos una consulta simple para comprobar el código del departamento
                        $consultaComprobarCodDepartamento = $mysqli->query("SELECT T02_CodDepartamento FROM T02_Departamento WHERE T02_CodDepartamento = '$codDepartamento'");

                        // Comprobamos si hay algún error en la consulta
                        if (!$consultaComprobarCodDepartamento) {
                            throw new Exception("Error en la consulta: " . $mysqli->error);
                        }

                        // Obtenemos el resultado de la consulta como un objeto
                        $departamentoExistente = $consultaComprobarCodDepartamento->fetch_object();

                        // COMPROBACION DE ERROR
                        if ($departamentoExistente) {
                            $aErrores['CodDepartamento'] = "El código de departamento ya existe";
                        }
                    } catch (mysqli_sql_exception $ex) {
                        echo ("<div style='color: red' class='fs-4 text'>Fallo al conectar a MySQL (" . $mysqli->connect_errno . ")</div>" . $mysqli->connect_error);
                    } finally {
                        // Cerramos la conexión
                        if ($mysqli && $mysqli->connect_errno === 0) {
                            $mysqli->close();
                        }
                    }
                }
                $aErrores['DescDepartamento'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['DescDepartamento'], 255, 1, OBLIGATORIO);
                $aErrores['FechaCreacionDepartamento'] = NULL;
                $aErrores['VolumenDeNegocio'] = validacionFormularios::comprobarFloat($_REQUEST['VolumenDeNegocio'], TAM_MAX_FLOAT, TAM_MIN_FLOAT, OBLIGATORIO);
                $aErrores['FechaBajaDepartamento'] = NULL;

                /*
                 * En este foreach recorremos el array buscando que exista NULL (Los metodos anteriores si son correctos devuelven NULL)
                 * y en caso negativo cambiara el valor de '$entradaOK' a false y borrara el contenido del campo.
                 */
                foreach ($aErrores as $campo => $error) {
                    if ($error != null) {
                        $_REQUEST[$campo] = "";
                        $entradaOK = false;
                    }
                }
            } else {
                $entradaOK = false;
            }
            //En caso de que '$entradaOK' sea true, cargamos las respuestas en el array '$aRespuestas'
            if ($entradaOK) {
                // Utilizamos el bloque 'try'
                try {
                    // CONEXION CON LA BD
                    $mysqli = new mysqli(DSN, USERNAME, PASSWORD, DBNAME);

                    echo ("<div style='color: green' class='fs-4 text'>Conexión exitosa a MySQL</div>" . $mysqli->host_info);

                    // Cargo el array con las respuestas
                    $aRespuestas['CodDepartamento'] = strtoupper($_REQUEST['CodDepartamento']);
                    $aRespuestas['DescDepartamento'] = $_REQUEST['DescDepartamento'];
                    $aRespuestas['FechaCreacionDepartamento'] = 'now()'; // Cargo la fecha actual y hora actual
                    $aRespuestas['VolumenDeNegocio'] = $_REQUEST['VolumenDeNegocio'];
                    $aRespuestas['FechaBajaDepartamento'] = 'NULL';

                    // CONSULTA CON QUERY()
                    // Se ejecuta la consulta de insercion                    
                    $numeroFilas = $mysqli->query("INSERT INTO T02_Departamento VALUES ('" . $aRespuestas['CodDepartamento'] . "','" . $aRespuestas['DescDepartamento'] . "'," . $aRespuestas['FechaCreacionDepartamento'] . "," . $aRespuestas['VolumenDeNegocio'] . "," . $aRespuestas['FechaBajaDepartamento'] . ");");

                    // Ejecutando la declaración SQL y mostramos un mensaje en caso de que se inserte u ocurra un error.
                    if ($numeroFilas !== false && $numeroFilas > 0) {
                        echo "Los datos se han insertado correctamente en la tabla Departamento.";

                        // Preparamos y ejecutamos la consulta SQL
                        $resultadoConsultaPreparada = $mysqli->query("SELECT * FROM T02_Departamento");

                        // Creamos una tabla en la que mostraremos la tabla de la BD
                        echo('<div class="ejercicio"><h2>Con prepare() y execute():</h2><table class="ej16"><tr><th>Codigo</th><th>Descripcion</th><th>Fecha de alta</th><th>Volumen</th><th>Fecha de baja</th></tr>');

                        /* Recorremos todos los valores de la tabla, columna por columna */
                        while ($oDepartamento = $resultadoConsultaPreparada->fetch_object()) {
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
                    } else {
                        echo "Hubo un error al insertar los datos en la tabla Departamento.";
                    }
                } catch (mysqli_sql_exception $ex) {
                    echo ("<div style='color: red' class='fs-4 text'>Fallo al conectar a MySQL (" . $mysqli->connect_errno . ")</div>" . $mysqli->connect_error);
                } finally {
                    // Cerramos la conexión
                    if ($mysqli && $mysqli->connect_errno === 0) {
                        $mysqli->close();
                    }
                }
            } else {
                ?>
                <!-- Codigo del formulario -->
                <form name="insercionValoresTablaDepartamento" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <fieldset>
                        <table>
                            <thead>
                                <tr>
                                    <th class="rounded-top" colspan="3"><legend>Creación de Departamento</legend></th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <!-- CodDepartamento Obligatorio -->
                                    <td class="d-flex justify-content-start">
                                        <label for="CodDepartamento">Codigo de Departamento:</label>
                                    </td>
                                    <td>                                                                                                <!-- El value contiene una operador ternario en el que por medio de un metodo 'isset()'
                                                                                                                                        comprobamos que exista la variable y no sea 'null'. En el caso verdadero devovleremos el contenido del campo
                                                                                                                                        que contiene '$_REQUEST' , en caso falso sobrescribira el campo a '' .-->
                                        <input class="obligatorio d-flex justify-content-start" type="text" placeholder="AAD" name="CodDepartamento" value="<?php echo (isset($_REQUEST['CodDepartamento']) ? $_REQUEST['CodDepartamento'] : ''); ?>">
                                    </td>
                                    <td class="error">
                                        <?php
                                        if (!empty($aErrores['CodDepartamento'])) {
                                            echo $aErrores['CodDepartamento'];
                                        }
                                        ?> <!-- Aquí comprobamos que el campo del array '$aErrores' no esta vacío, si es así, mostramos el error. -->
                                    </td>
                                </tr>
                                <tr>
                                    <!-- DescDepartamento Obligatorio -->
                                    <td class="d-flex justify-content-start">
                                        <label for="DescDepartamento">Descripción de Departamento:</label>
                                    </td>
                                    <td>                                                                                                <!-- El value contiene una operador ternario en el que por medio de un metodo 'isset()'
                                                                                                                                        comprobamos que exista la variable y no sea 'null'. En el caso verdadero devovleremos el contenido del campo
                                                                                                                                        que contiene '$_REQUEST' , en caso falso sobrescribira el campo a '' .-->
                                        <input class="obligatorio d-flex justify-content-start" type="text" name="DescDepartamento" placeholder="Departamento de Ventas" value="<?php echo (isset($_REQUEST['DescDepartamento']) ? $_REQUEST['DescDepartamento'] : ''); ?>">
                                    </td>
                                    <td class="error">
                                        <?php
                                        if (!empty($aErrores['DescDepartamento'])) {
                                            echo $aErrores['DescDepartamento'];
                                        }
                                        ?> <!-- Aquí comprobamos que el campo del array '$aErrores' no esta vacío, si es así, mostramos el error. -->
                                    </td>
                                </tr>
                                <tr>
                                    <!-- FechaCreacionDepartamento Opcional -->
                                    <td class="d-flex justify-content-start">
                                        <label for="FechaCreacionDepartamento">Fecha de Creación:</label>
                                    </td>
                                    <td>                                                                                                <!-- El value contiene una operador ternario en el que por medio de un metodo 'isset()'
                                                                                                                                        comprobamos que exista la variable y no sea 'null'. En el caso verdadero devovleremos el contenido del campo
                                                                                                                                        que contiene '$_REQUEST' , en caso falso sobrescribira el campo a '' .-->
                                        <input disabled class="d-flex justify-content-start bloqueado" type="text" name="FechaCreacionDepartamento"  value="<?php echo ($fechaYHoraActualCreacionFormateada); ?>">
                                    </td>
                                    <td class="error">
                                        <?php
                                        if (!empty($aErrores['FechaCreacionDepartamento'])) {
                                            echo $aErrores['FechaCreacionDepartamento'];
                                        }
                                        ?> <!-- Aquí comprobamos que el campo del array '$aErrores' no esta vacío, si es así, mostramos el error. -->
                                    </td>
                                </tr>
                                <tr>
                                    <!-- VolumenNegocio Obligatorio -->
                                    <td class="d-flex justify-content-start">
                                        <label for="VolumenDeNegocio">Volumen de Negocio:</label>
                                    </td>
                                    <td>                                                                                                <!-- El value contiene una operador ternario en el que por medio de un metodo 'isset()'
                                                                                                                                        comprobamos que exista la variable y no sea 'null'. En el caso verdadero devovleremos el contenido del campo
                                                                                                                                        que contiene '$_REQUEST' , en caso falso sobrescribira el campo a '' .-->
                                        <input class="obligatorio d-flex justify-content-start" type="text" name="VolumenDeNegocio" placeholder="1234.5" value="<?php echo (isset($_REQUEST['VolumenDeNegocio']) ? $_REQUEST['VolumenDeNegocio'] : ''); ?>">
                                    </td>
                                    <td class="error">
                                        <?php
                                        if (!empty($aErrores['VolumenDeNegocio'])) {
                                            echo $aErrores['VolumenDeNegocio'];
                                        }
                                        ?> <!-- Aquí comprobamos que el campo del array '$aErrores' no esta vacío, si es así, mostramos el error. -->
                                    </td>
                                </tr>
                                <tr>
                                    <!-- FechaBaja Opcional -->
                                    <td class="d-flex justify-content-start">
                                        <label for="FechaBaja">Fecha de Baja:</label>
                                    </td>
                                    <td>                                                                                                <!-- El value contiene una operador ternario en el que por medio de un metodo 'isset()'
                                                                                                                                        comprobamos que exista la variable y no sea 'null'. En el caso verdadero devovleremos el contenido del campo
                                                                                                                                        que contiene '$_REQUEST' , en caso falso sobrescribira el campo a '' .-->
                                        <input disabled class="d-flex justify-content-start bloqueado" type="text" name="FechaBaja" placeholder="YYYY/mm/dd HH:ii:ss" value="<?php echo (isset($_REQUEST['FechaBaja']) ? $_REQUEST['FechaBaja'] : ''); ?>">
                                    </td>
                                    <td class="error">
                                        <?php
                                        if (!empty($aErrores['FechaBaja'])) {
                                            echo $aErrores['FechaBaja'];
                                        }
                                        ?> <!-- Aquí comprobamos que el campo del array '$aErrores' no esta vacío, si es así, mostramos el error. -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="submit" name="enviar">Crear</button>
                    </fieldset>
                </form>
                <?php
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

