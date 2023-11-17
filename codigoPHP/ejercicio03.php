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
            /*
             * @author Rebeca Sánchez Pérez
             * @version 1.5
             * @since 15/11/2023
             */
            // ANOTACION: Crear dos ejercicios que sea 3.1 y 3.2 separando las 2 formas de hacerlo, con prepare query y con exec
            // ANOTACION: Escribir la consulta en una variable heredoc
        
            // DECLARACION E INICIALIZACION DE VARIABLES
            // Se incuye la libreria de validacion para usar los metodos de validacion de las entradas del formulario
            require_once '../core/231018libreriaValidacion.php';
            // Se incuye la libreria de configuracion de bases de datos que almacena las constantes de la conexion
            require_once '../config/confDB.php';
            // La varible $entradaOK es un interruptor que recibe el valor true cuando no existe ningun error en la entrada
            $entradaOK = true;
            // El array $aRespuestas almacena los valores que son introducidos en cada input del formulario
            $aRespuestas =[
                'codDepartamento' => '',
                'descDepartamento' => '',
                'fechaCreacionDepartamento' => 'now()',
                'volumenNegocio' => '',
                'fechaBaja' => 'null'
            ];
            // El array $aErrores almacena los valores que no cumplan los requisitos que se hayan introducido en el formulario
            // No se incluyen la fecha de creacion ni la fecha de baja porque no se validan 
            $aErrores = [
                'codDepartamento' => '',
                'descDepartamento' => '',
                'volumenNegocio' => ''   
            ];
            
            // Si el fromulario ha sido rellenado, se valida la entrada
            if (isset($_REQUEST['enviar'])){
                // VALIDACIONES
                // Se comprueba que el valor introducido en el campo 'codDepartamento' sea un valor alfabetico con longitud de 3 caracterres, si no lo es, se añade un mensaje de error al array $aErrores
                $aErrores['codDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['codDepartamento'],3,3,1);
                // Se comprueba que el codigo de departamento no exista en la base de datos
                if ($aErrores['codDepartamento'] == null) {
                    try {
                        // Se instancia un objeto tipo PDO que establece la conexion a la base de datos con el usuario especificado
                        $miDB = new PDO('mysql:host='.IPMYSQL.'; dbname='.NOMBREDB,USUARIO,PASSWORD);
                        // Se configuran las excepciones
                        $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                        // Se prepara la consulta que filtra los departamentos por codigo
                        $consultaPorCodigo = $miDB->prepare('SELECT * FROM T02_Departamento WHERE T02_CodDepartamento = "'.$_REQUEST['codDepartamento'].'";');
                        // Se ejecuta la query
                        $consultaPorCodigo->execute(); 
                        // Si la consulta devuelve alguna fila añadirmos un error al array errores
                        if ($consultaPorCodigo->rowCount() > 0) {
                            $aErrores['codDepartamento'] = "Ese codigo de departamento ya existe";
                        }
                    } catch (PDOException $miExcepcionPDO) {
                        echo $miExcepcionPDO->getCode();
                        echo $miExcepcionPDO->getMessage();
                    } finally {
                        unset($miDB);
                    }
                }

                // Se comprueba que el valor introducido en el campo 'descDepartamento' sea un valor alfabetico con longitud maxima de 255 caracterres, si no lo es, se añade un mensaje de error al array $aErrores
                $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['descDepartamento'],255,1,1);

                // Se comprueba que el valor introducido en el campo 'volumenNegocio' sea un numero real, si no lo es, se añade un mensaje de error al array $aErrores
                $aErrores['volumenNegocio'] = validacionFormularios::comprobarFloat($_REQUEST['volumenNegocio'],PHP_FLOAT_MAX,-PHP_FLOAT_MAX,1);

                // Se recorre el array de errores 
                foreach($aErrores as $campo => $error){
                    // Si existe algun error se cambia el valor de $entradaOK a false y se limpia ese campo
                    if($error != null){
                        $_REQUEST[$campo] = '';
                        $entradaOK = false;
                    }
                }

            // Si el formulario NUNCA ha sido rellenado, se inicializa $entradaOK a false    
            }else{ 
                $entradaOK = false;
            }

            // Si todos los valores intruducidos son correctos, se muestran los campos del formulario y sus respuestas
            if ($entradaOK){
                // TRATAMIENTO DE DATOS
                // Se añaden al array $aRespuestas las respuestas cuando son correctas
                $aRespuestas['codDepartamento'] = strtoupper($_REQUEST['codDepartamento']);
                $aRespuestas['descDepartamento'] = $_REQUEST['descDepartamento'];
                $aRespuestas['volumenNegocio'] = $_REQUEST['volumenNegocio'];

                // Se ataca a la base de datos
                try {
                    // Se instancia un objeto tipo PDO que establece la conexion a la base de datos con el usuario especificado
                    $miDB = new PDO('mysql:host='.IPMYSQL.'; dbname='.NOMBREDB,USUARIO,PASSWORD);
                    
                    // SOLUCION CON EXEC()
                    // Se almacena el resultado de la consulta de insercion
                    $numRegistros = $miDB->exec('insert into T02_Departamento values ("'.$aRespuestas['codDepartamento'].'","'.$aRespuestas['descDepartamento'].'",'.$aRespuestas['fechaCreacionDepartamento'].','.$aRespuestas['volumenNegocio'].','.$aRespuestas['fechaBaja'].');');
                    // Se almacena el resultado de la consulta select
                    $resultadoConsulta = $miDB->query('select * from T02_Departamento');
                    
//                    // SOLUCION CON PREPARE()
//                    // Se inicializa la consulta de insercion
//                    $consulta = 'INSERT INTO Departamento VALUES ("'.$aRespuestas['codDepartamento'].'","'.$aRespuestas['descDepartamento'].'",'.$aRespuestas['fechaCreacionDepartamento'].','.$aRespuestas['volumenNegocio'].','.$aRespuestas['fechaBaja'].')';
//                    // Se almacena el resultado de la consulta
//                    $resultadoConsultaPrepare = $miDB->prepare($consulta);
//                    // Se ejecuta la consulta
//                    $resultadoConsultaPrepare->execute();
//                    // Se almacena el resultado de la consulta select
//                    $resultadoConsulta = $miDB->prepare('select * from Departamento');
//                    // Se ejecuta la query de seleccion
//                    $resultadoConsulta->execute();
                    
                    // Se almacena el numero de filas afectadas
                    $count = $resultadoConsulta->rowCount();
                    echo('<div class="ejercicio">');
                    // Se muestra por pantalla el numero de tuplas de la tabla departamentos
                    echo('Numero total de departamentos: <b>'.$count.'</b></div>');
                    
                    // Se crea una tabla para imprimir las tuplas
                    echo('<div class="ejercicio"><h2>Departamentos:</h2><table class="ej16"><tr><th>Codigo</th><th>Descripcion</th><th>Fecha de alta</th><th>Volumen</th><th>Fecha de baja</th></tr>');
                    // Se instancia un objeto tipo PDO que almacena cada fila de la consulta
                    while($oDepartamento = $resultadoConsulta->fetchObject()){
                        echo('<tr>');
                        echo('<td>'.$oDepartamento->T02_CodDepartamento.'</td>');
                        echo('<td>'.$oDepartamento->T02_DescDepartamento.'</td>');
                        echo('<td>'.$oDepartamento->T02_FechaCreacionDepartamento.'</td>');
                        echo('<td>'.$oDepartamento->T02_VolumenDeNegocio.'</td>');
                        echo('<td>'.$oDepartamento->T02_FechaBajaDepartamento.'</td>');
                        echo('</tr>');
                    }
                    echo('</table>');                    
                    echo('</div>');

                    // Se cierra la conexion con la base de datos
                    unset($miDB);
                } catch (PDOException $exception) {
                    // Si aparecen errores, se muestra por pantalla el error
                    echo('<div class="ejercicio"><span class="error">❌ Ha fallado la conexion: '. $exception->getMessage().'</span></div>');
                }

            // Si no son correctos los valores de entrada, se muestra el formulario    
            }else{ 
                ?> 
                <div class="ejercicio">
                    <h3>Inserte un departamento nuevo:</h3>
                    <!-- Se crea un formulario tipo post -->
                    <form name= "ejercicio3" action="<?php echo $_SERVER['PHP_SELF'];?>" id="form3" method="post">
                        <table class="formulario">
                            <tr>
                                <td><label for="codDepartamento">Codigo: </label></td>
                                <td><input type="text" name="codDepartamento" id="codDepartamento" class="iObligatorio" value="<?php echo(isset($_REQUEST['codDepartamento'])?$_REQUEST['codDepartamento']:'') ?>"></td>
                                <td><?php // Se muestra el mensaje de error 
                                    echo('<p class="error">'.$aErrores['codDepartamento'].'</p>');?>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="descDepartamento">Descripcion: </label></td>
                                <td><input type="text" name="descDepartamento" id="descDepartamento" class="iObligatorio" value="<?php echo(isset($_REQUEST['descDepartamento'])?$_REQUEST['descDepartamento']:'') ?>"></td>
                                <td><?php // Se muestra el mensaje de error 
                                    echo('<p class="error">'.$aErrores['descDepartamento'].'</p>');?>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="fechaCreacionDepartamento">Fecha de alta: </label></td>
                                <td><input type="text" name="fechaCreacionDepartamento" id="fechaCreacionDepartamento" value="<?php echo($oFecha=date('Y-m-d H:i:s')) ?>" disabled></td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="volumenNegocio">Volumen de negocio: </label></td>
                                <td><input type="text" name="volumenNegocio" id="volumenNegocio" class="iObligatorio" value="<?php echo(isset($_REQUEST['volumenNegocio'])?$_REQUEST['volumenNegocio']:'') ?>"></td>
                                <td><?php // Se muestra el mensaje de error
                                    echo('<p class="error">'.$aErrores['volumenNegocio'].'</p>');?>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="fechaBaja">Fecha de baja: </label></td>
                                <td><input type="text" name="fechaBaja" id="fechaBaja" value="<?php echo('') ?>" disabled></td>
                                <td>
                                </td>
                            </tr>
                        </table>
                        <input type="submit" form="form3" value="Enviar" name="enviar">
                    </form>
                </div>
            <?php
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

