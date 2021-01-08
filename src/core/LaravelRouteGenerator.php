<?php

namespace App\core;

use App\contracts\RouteGeneratorInterface;

class LaravelRouteGenerator 
{
    public function __construct(RouteGeneratorInterface $class)
    {
        $this->class = $class;
    }
    /**
    * store class instance
    */
    protected $class;

    /*
    * store method name & httpverb from methods
    */
    protected $methodsData;

    /**
    * store response of class
    */
    protected $response;

    /**
    * set class instance to class property
    * @param Class @class
    * @return boolean
    */
    public function setClass(RouteGeneratorInterface $class)
    {
        $this->class = $class;
    }

    /**
     * Determine Class Name
     * 
     * @return String
     */
    public function getClassName() :String
    {
        return get_class($this->class);
    }

    /**
     * Return All Methods in Class
     * 
     * @return Array
     */
    public function getClassMethods() :Array
    {
        return get_class_methods($this->class);
    }

    public function initialzeClassToRender()
    {
        echo "start initiliaze class to render";
        $methods = $this->getClassMethods($this->class);

        foreach ($methods as $method)
        {
            $this->methodsData[] = $this->extractionDataFromMethod($method);
        }
        var_dump($this->methodsData);
    }

    protected function extractionDataFromMethod($method)
    {
        foreach ( $this->httpVerbType() as $type ){
            $check = strstr($method, $type['name']);
            if ( $check )
                $variable = [
                    'method'    =>  $method,
                    'httpVerb'  =>  $type['name'],
                ];
        }
        return $variable;
    }


    protected function setRouteStyle($routes)
    {
        foreach ( $routes['apiRoute'] as $route ){
            $style[] = 'Route::'.$route['type']."('".$routes['className'].'@'.$route['methodName'].')';
        }
        return $style;
    }

    protected function writeRouteToFile($datas, $file)
    {
         $myFile = fopen($file, 'a+');
         foreach ( $datas as $data )
         {
            fwrite($myFile,$data.PHP_EOL);
         }
         fclose();
         return true;
    }

    /**
     * set Http Verb Type
     */
    protected function httpVerbType()
    {
        return [
            [ 'name'  =>'get'],
            [ 'name' => 'post'],
            [ 'name' => 'patch'],
            [ 'name' => 'delete'],
        ];
    }
    
    public function get(){
        if ( !is_array($this->methodsData) )
            return $this->response($this->methodsData);
        foreach($this->methodsData as $method )
            $get[] = $this->response($method);
    
        return $get;
    }

    public function response($response)
    {
        return [
            'type'  =>  $response['httpVerb'],
            'role'  =>  null,
            'name'  =>  null,
            'methodName' => $response['method'],
        ];
    }

    protected function readRouteFile($file)
    {
        $myFile = fopen($file, "r");
        return fread($myFile);
    }
}