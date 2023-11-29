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
        <h1>Ejercicio 4</h1>
    </header>
    <main>
        <h2>Formulario de búsqueda de departamentos por descripción (por una parte del campo DescDepartamento, si el usuario no pone nada deben aparecer todos los departamentos)</h2>
        <?php
            /*
             * @author Rebeca Sánchez Pérez
             * @version 1.2
             * @since 15/11/2023
             */
        
            // DECLARACION E INICIALIZACION DE VARIABLES
            // Se incuye la libreria de validacion para usar los metodos de validacion de las entradas del formulario
            require_once '../core/231018libreriaValidacion.php';
            // Se incuye la libreria de configuracion de bases de datos que almacena las constantes de la conexion
            require_once '../config/confDBPDO.php';
            // La varible $entradaOK es un interruptor que recibe el valor true cuando no existe ningun error en la entrada
            $entradaOK = true;
            // El array $aRespuestas almacena los valores que son introducidos en cada input del formulario
            $aRespuestas =[
                'descDepartamentoABuscar' => ''
            ];
            // El array $aErrores almacena los valores que no cumplan los requisitos que se hayan introducido en el formulario
            $aErrores = [
                'descDepartamentoABuscar' => ''    
            ];
            
            // Si el fromulario ha sido rellenado, se valida la entrada
            if (isset($_REQUEST['enviar'])){
                // VALIDACIONES
                // Se comprueba que el valor introducido en el campo 'descDepartamento' sea un valor alfabetico con longitud maxima de 255 caracterres, si no lo es, se añade un mensaje de error al array $aErrores
                $aErrores['descDepartamentoABuscar'] = validacionFormularios::comprobarAlfabetico($_REQUEST['descDepartamentoABuscar'],255,1,0);

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
            
            // TRATAMIENTO DE DATOS
            // Se añaden al array $aRespuestas las respuestas cuando son correctas
            if($entradaOK){
                $aRespuestas['descDepartamentoABuscar'] = $_REQUEST['descDepartamentoABuscar'];
            }
            ?>
        
            <div class="ejercicio">
                <!-- Se crea un formulario tipo post para agregar la opcion de busqueda-->
                <form name= "ejercicio3" action="<?php echo $_SERVER['PHP_SELF'];?>" id="form3" method="post">
                    <table class="barraBusqueda">
                        <tr>
                            <td><label for="descDepartamentoABuscar">Descripcion a buscar: </label></td>
                            <td><input type="text" name="descDepartamentoABuscar" id="descDepartamentoABuscar" value="<?php echo(isset($_REQUEST['descDepartamentoABuscar'])?$_REQUEST['descDepartamentoABuscar']:'') ?>"></td>
                            <td><input type="submit" form="form3" value="Buscar" name="enviar" class="botonBuscar"></td>
                            <td><?php // Se muestra el mensaje de error 
                            echo('<p class="error">'.$aErrores['descDepartamentoABuscar'].'</p>');?></td>
                        </tr>
                    </table>
                </form>
            </div>
        
            <?php
            // Se ataca a la base de datos
            try {
                // Se instancia un objeto tipo PDO que establece la conexion a la base de datos con el usuario especificado
                $miDB = new PDO('mysql:host='.IPMYSQL.'; dbname='.NOMBREDB,USUARIO,PASSWORD);

                                // Se inicializa la consulta de insercion
                $consulta = "select * from T02_Departamento where T02_DescDepartamento like '%".$aRespuestas['descDepartamentoABuscar']."%';";
                // Se almacena el resultado de la consulta
                $resultadoConsulta = $miDB->prepare($consulta);
                // Se ejecuta la consulta
                $resultadoConsulta->execute();
//                // Se almacena el numero de filas afectadas
//                $count = $resultadoConsulta->rowCount();
//                echo('<div class="ejercicio">');
//                // Se muestra por pantalla el numero de tuplas de la tabla departamentos
//                echo('Coincidencias: <b>'.$count.'</b></div>');

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

