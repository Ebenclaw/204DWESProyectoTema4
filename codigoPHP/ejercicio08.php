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
        <h1>Ejercicio 8</h1>
    </header>
    <main>
        <h2>JSON: Página web que toma datos (código y descripción) de la tabla Departamento y guarda en un fichero departamento.json. (COPIA DE SEGURIDAD / EXPORTAR). El fichero exportado se encuentra en el directorio .../tmp/ del servidor</h2>
        <?php
            /*
             * @author Rebeca Sánchez Pérez
             * @version 1.0
             * @since 20/11/2023
             */
        
            // DECLARACION E INICIALIZACION DE VARIABLES
            // Se incuye la libreria de validacion para usar los metodos de validacion de las entradas del formulario
            require_once '../core/231018libreriaValidacion.php';
            // Se incuye la libreria de configuracion de bases de datos que almacena las constantes de la conexion
            require_once '../config/confDB.php';            
            // La varible $entradaOK es un interruptor que recibe el valor true cuando no existe ningun error en la entrada
            $entradaOK = true;
            // Inicializamos un array vacío para almacenar todos los departamentos
            $aDepartamentos = [];
                        
            // Se ataca a la base de datos
            try {
                // Se instancia un objeto tipo PDO que establece la conexion a la base de datos con el usuario especificado
                $miDB = new PDO('mysql:host='.IPMYSQL.'; dbname='.NOMBREDB,USUARIO,PASSWORD);
                // Se inicializa una variable heredoc que almacena la consulta
                $sql1 = <<< SQL
                    select * from T02_Departamento
                SQL;
                // Se prepara la consulta
                $consulta = $miDB->prepare($sql1);   
                
                // Se ejecuta la consulta
                $consulta->execute();
                
                // Se guarda el primer registro como un objeto
                $oResultado = $consulta->fetchObject();
                
                // Se instancia un objeto tipo PDO que almacena cada fila de la consulta
                while($oResultado){
                    // Se guardan los valores en un array asociativo
                    $aDepartamento = [
                        'codDepartamento' => $oResultado->T02_CodDepartamento,
                        'descDepartamento' => $oResultado->T02_DescDepartamento,
                        'fechaCreacionDepartamento' => $oResultado->T02_FechaCreacionDepartamento,
                        'volumenDeNegocio' => $oResultado->T02_VolumenDeNegocio,
                        'fechaBaja' => $oResultado->T02_FechaBajaDepartamento
                    ];

                    // Añadimos el array $aDepartamento al array $aDepartamentos
                    $aDepartamentos[] = $aDepartamento;

                    //Guardo el registro actual y avanzo el puntero al siguiente registro que obtengo de la consulta
                    $oResultado = $consulta->fetchObject();
                }
                
                // 
                $json = json_encode($aDepartamentos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                
                // Se graban los departamento en el fichero especificado
                if(file_put_contents("../tmp/departamentos1.json", $json)){
                    // Si no aparecen errores, se muestra un mensaje de exito
                    echo('<div class="ejercicio">Se han exportado los datos correctamente ✅</div>');
                }else{
                    // Si aparecen errores, se muestra por pantalla el error
                    echo('<div class="ejercicio"><span class="error">❌ No se han podido exportar los datos</span></div>');
                }
            } catch (PDOException $exception) {
                // Si aparecen errores, se muestra por pantalla el error
                echo('<div class="ejercicio"><span class="error">❌ Ha fallado la conexion: '. $exception->getMessage().'</span></div>');
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

