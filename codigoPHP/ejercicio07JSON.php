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
        <h1>Ejercicio 7.1</h1>
    </header>
    <main>
        <h2>JSON: Página web que toma datos (código y descripción) de la tabla Departamento y guarda en un fichero departamento.json. (COPIA DE SEGURIDAD / EXPORTAR). El fichero exportado se encuentra en el directorio .../tmp/ del servidor</h2>
        <?php
            /*
             * @author Rebeca Sánchez Pérez
             * @version 1.0
             * @since 21/11/2023
             */
        
            // DECLARACION E INICIALIZACION DE VARIABLES
            // Se incuye la libreria de validacion para usar los metodos de validacion de las entradas del formulario
            require_once '../core/231018libreriaValidacion.php';
            // Se incuye la libreria de configuracion de bases de datos que almacena las constantes de la conexion
            require_once '../config/confDBPDO.php';            
            // La varible $entradaOK es un interruptor que recibe el valor true cuando no existe ningun error en la entrada
            $entradaOK = true;
                        
            // Se ataca a la base de datos
            try {
                // Se instancia un objeto tipo PDO que establece la conexion a la base de datos con el usuario especificado
                $miDB = new PDO('mysql:host='.IPMYSQL.'; dbname='.NOMBREDB,USUARIO,PASSWORD);
                
                // Se indica la ruta del archivo y la guardamos en una variable
                $rutaArchivoJSON = '../tmp/departamentos.json';
                // Se lee el contenido del archivo JSON
                $contenidoArchivoJSON = file_get_contents($rutaArchivoJSON);
                // Se decodifica el JSON a un array asociativo
                $aContenidoDecodificadoArchivoJSON = json_decode($contenidoArchivoJSON, true);
                
                // Se inicia la transaccion
                $miDB->beginTransaction();
                
                // Se inicializan variables heredoc que almacenan las consultas
                $sql1 = <<< SQL
                    insert into T02_Departamento values (:CodDepartamento, :DescDepartamento, :FechaCreacionDepartamento, :VolumenDeNegocio, :FechaBajaDepartamento)
                SQL;
                $sql2 = <<< SQL
                    select * from T02_Departamento
                SQL;
                
                // Se prepara la consulta de insercion
                $consulta1 = $miDB->prepare($sql1);
                
                // Se recorre cada registro que contiene el fichero json
                foreach ($aContenidoDecodificadoArchivoJSON as $departamento) { 
                    $codDepartamento = $departamento['codDepartamento'];
                    $descDepartamento = $departamento['descDepartamento'];
                    $fechaCreacionDepartamento = $departamento['fechaCreacionDepartamento'];
                    $volumenDeNegocio = $departamento['volumenDeNegocio'];
                    $fechaBajaDepartamento = $departamento['fechaBajaDepartamento'];

                    // Si la fecha de baja está vacía asignamos el valor 'NULL'
                    if (empty($fechaBajaDepartamento)) {
                        $fechaBajaDepartamento = NULL;
                    }

                    // Se almacenan en un array los registros leidos
                    $aRegistros = [
                        ':CodDepartamento' => $codDepartamento,
                        ':DescDepartamento' => $descDepartamento,
                        ':FechaCreacionDepartamento' => $fechaCreacionDepartamento,
                        ':VolumenDeNegocio' => $volumenDeNegocio,
                        ':FechaBajaDepartamento' => $fechaBajaDepartamento
                    ];
                    
                    // Se ejecuta la consulta
                    $consulta1->execute($aRegistros);
                }
                
                // Se confiman los datos si todo ha funcionado correctamente
                $miDB->commit();
                // Se muestra el mensaje de exito
                echo('<div class="ejercicio">Se han importado los datos correctamente ✅</div>');
                
                // Se prepara la consulta de visualizacion
                $consulta2 = $miDB->prepare($sql2);
                // Se ejecuta la consulta
                $consulta2->execute();
                // Se crea una tabla para imprimir las tuplas
                echo('<div class="ejercicio"><h2>Departamentos:</h2><table class="ej16"><tr><th>Codigo</th><th>Descripcion</th><th>Fecha de alta</th><th>Volumen</th><th>Fecha de baja</th></tr>');
                // Se instancia un objeto tipo PDO que almacena cada fila de la consulta
                while($oRegistro = $consulta2->fetchObject()){
                    echo('<tr>');
                    echo('<td>'.$oRegistro->T02_CodDepartamento.'</td>');
                    echo('<td>'.$oRegistro->T02_DescDepartamento.'</td>');
                    echo('<td>'.$oRegistro->T02_FechaCreacionDepartamento.'</td>');
                    echo('<td>'.$oRegistro->T02_VolumenDeNegocio.'</td>');
                    echo('<td>'.$oRegistro->T02_FechaBajaDepartamento.'</td>');
                    echo('</tr>');
                }
                echo('</table>');                    
                echo('</div>');
                
            } catch (PDOException $exception) {
                // Si aparecen errores, se muestra por pantalla el error
                echo('<div class="ejercicio"><span class="error">❌ Ha fallado la conexion: '. $exception->getMessage().'</span></div>');
                // Se cancela la transaccion si aparece algun error
                $miDB->rollBack();
            } finally{
                // Se cierra la conexion con la base de datos
                unset($miDB);
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

