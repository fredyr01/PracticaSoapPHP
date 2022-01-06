<?php
    //* Ruta de la clase Econea/nusoap
    require_once "vendor/econea/nusoap/src/nusoap.php";
    $namespace = "InsertCategorySoap";
    $server = new soap_server();
    $server->configureWSDL("InsertCategory",$namespace);
    $server->wsdl->schemaTargetNamespace = $namespace;


    //* Estructura de servicio
    $server->wsdl->addComplexType(
        'InsertCategory',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'usu_nom' => array('name' => 'usu_nom', 'type' => 'xsd:string'),
            'usu_ape' => array('name' => 'usu_ape', 'type' => 'xsd:string'),
            'usu_correo' => array('name' => 'usu_correo', 'type' => 'xsd:string')
        )
    );

    //* Estructura de la respuesta
    $server->wsdl->addComplexType(
        'response',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'Resultado' => array('name' => 'Resultado', 'type' => 'xsd:boolean')
        )
    );

    $server->register(
        "InsertCategoryService",
        array("InsertCategory" => "tns:InsertCategory"),
        array("InsertCategory" => "tns:response"),
        $namespace,
        false,
        "rpc",
        "encoded",
        "Inserta una categoria"
    );

    function InsertCategoryService($request){
        require_once "config/conexion.php";
        require_once "models/Usuario.php";

        $usuario = new Usuario();
        $usuario->insert_usuario($request["usu_nom"],$request["usu_ape"],$request["usu_correo"]);
        return array(
            "Resultado" => true
        );
    }

    $POST_DATA = file_get_contents("php://input");
    $server->service($POST_DATA);
    exit();
?>