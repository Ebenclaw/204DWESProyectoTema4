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
        <h1>Ejercicio 5</h1>
    </header>
    <main>
        <h2>Pagina web que añade tres registros a nuestra tabla Departamento utilizando tres instrucciones insert y una transacción, de tal forma que se añadan los tres registros o no se añada ninguno</h2>
        <?php
            /*
             * @author Rebeca Sánchez Pérez
             * @version 1.2
             * @since 17/11/2023
             */
            // ANOTACION: cargar la fecha con una variable en php en lugar de SQL.
        
            // DECLARACION E INICIALIZACION DE VARIABLES
            // Se incuye la libreria de validacion para usar los metodos de validacion de las entradas del formulario
            require_once '../core/231018libreriaValidacion.php';
            // Se incuye la libreria de configuracion de bases de datos que almacena las constantes de la conexion
            require_once '../config/confDB.php';            
            // La varible $entradaOK es un interruptor que recibe el valor true cuando no existe ningun error en la entrada
            $entradaOK = true;
            // El array $aRespuestas almacena los valores que son introducidos en cada input del formulario
            $aDepartamentos =[
                ['codDepartamento' => 'ABC',
                'descDepartamento' => 'departamento ABC',
                'fechaCreacionDepartamento' => now(),
                'volumenNegocio' => '123',
                'fechaBaja' => 'null'],
                
                ['codDepartamento' => 'ASD',
                'descDepartamento' => 'departamento ASD',
                'fechaCreacionDepartamento' => now(),
                'volumenNegocio' => '180',
                'fechaBaja' => 'null'],
                
                ['codDepartamento' => 'XYZ',
                'descDepartamento' => 'departamento xyz',
                'fechaCreacionDepartamento' => now(),
                'volumenNegocio' => '50',
                'fechaBaja' => 'null']
            ];    
                        
            // Se ataca a la base de datos
            try {
                // Se instancia un objeto tipo PDO que establece la conexion a la base de datos con el usuario especificado
                $miDB = new PDO('mysql:host='.IPMYSQL.'; dbname='.NOMBREDB,USUARIO,PASSWORD);
                // Se inicia la transaccion deshabilitando el modo autocomit
                $miDB->beginTransaction();
                // Se inicializa una variable heredoc que almacena la consulta
                $sql1 = <<< SQL
                    insert into T02_Departamento values(:codDepartamento, :descDepartamento, :fechaCreacionDepartamento, :volumenNegocio, :fechaBaja)
                SQL;
                $sql2 = <<< SQL
                    select * from T02_Departamento
                SQL;
                // Se prepara la consulta
                $consulta = $miDB->prepare($sql1);
                // Se recorre el array $aDepartamentos
                foreach($aDepartamentos as $departamento) { 
                    // Se inicializa un array que contiene los parametros bindeados de cada registro almacenado en $aDepartamentos
                    $parametros=[
                        ":codDepartamento" => $departamento["codDepartamento"],
                        ":descDepartamento" => $departamento["descDepartamento"],
                        ":fechaCreacionDepartamento" => $departamento["fechaCreacionDepartamento"], //now()
                        ":volumenNegocio" => $departamento["volumenNegocio"],
                        ":fechaBaja" => $departamento["fechaBaja"] //null
                    ];
                    // Se ejecuta cada registro
                    $consulta->execute($parametros); 
                }
                // Se confirman los cambios si todo ha ido bien
                $miDB->commit();
                
                // Se ejecuta la consulta de seleccion para mostrar los departamentos
                $resultadoConsulta = $miDB->query($sl2);
                // Se crea una tabla para imprimir las tuplas
                echo('<div class="ejercicio"><h2>Departamentos:</h2><table class="ej16"><tr><th>Codigo</th><th>Descripcion</th><th>Fecha de alta</th><th>Volumen</th><th>Fecha de baja</th></tr>');
                // Se instancia un objeto tipo PDO que almacena cada fila de la consulta
                while($oRegistro = $resultadoConsulta->fetchObject()){
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

