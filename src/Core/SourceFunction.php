<?php

function getClassName($class) :String
{
    return get_class($class);
}

function getClassMethods($class) :array
{
    return get_class_methods($class);
}

function getMethodInformationFromClass($class)
{
    $classMethods = getClassMethods($class);
    
    foreach ($classMethods as $method)
    {
        $info[] = searchForTrueMethods($method);
    }
    return $info;
}

function searchForTrueMethods($verb)
{
    foreach ( httpVerbType() as $type ){
        $check = strstr($verb, $type['name']);
        if ( $check )
            $variable = [
                'method'    =>  $verb,
                'httpVerb'  =>  $type['name'],
            ];
    }
    return getInformationFromMethod($variable);
    // return $variable;
}

function getInformationFromMethod($method)
{
    switch ($method['httpVerb']) {
        case 'get' :
            return response('get', $method);
            break;

        case 'post' :
            return response('post', $method);
            break;

        case 'patch' :
            return response('patch', $method);
            break;

        case 'delete' :
            return response('delete', $method);
            break;
    }
}

function setRouteStyle($routes)
{
    foreach ( $routes['apiRoute'] as $route ){
        $style[] = 'Route::'.$route['type']."('".$routes['className'].'@'.$route['methodName'].')';
    }
    return $style;
}

function writeRouteToFile($datas, $file)
{
     $myFile = fopen($file, 'a+');
     foreach ( $datas as $data )
     {
        fwrite($myFile,$data.PHP_EOL);
     }
     fclose();
     return true;
}

function readRouteFile($file)
{
    $myFile = fopen($file, "r");
    return fread($myFile);
}

function httpVerbType()
{
    return [
        [ 'name'  =>  'get', 'start' =>  0, 'end'   =>  3],
        [ 'name' => 'post', 'start' => 0, 'end' => 4],
        [ 'name' => 'patch', 'start' => 0, 'end' => 5],
        [ 'name' => 'delete', 'start' => 0, 'end' => 6],
    ];
}

function response($type, $parametr)
{
    return [
        'type'  =>  $type,
        'role'  =>  null,
        'name'  =>  null,
        'methodName' => $parametr['method'],
    ];}
?>