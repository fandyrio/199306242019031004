<?php
namespace Route;
use Route\Request;
class Route
{
    static $index=0;
    
    public static function validateRequest($end_point_fn, $controller_method, $num_call){
        self::$index+=1;
        $uri = self::processURI();
        $end_point_uri=$uri['end_point'];
        if($end_point_uri===""){
            $end_point_uri="home";
        }
        $args_uri=$uri['args'];
        $num_args_uri=$uri['num_args'];
        $final_end_point_uri;
        
        //proses end point function
        $fn_proses=self::prosesEndPointFn($end_point_fn);
        $pointer_fn=$fn_proses['end_point_fn'];
        $num_args_fn=$fn_proses['num_args_fn'];
       
        //combine fn and uri
        //var_dump($end_point_uri);
        if($pointer_fn===$end_point_uri){
            if($num_args_fn===$num_args_uri){
                //matched
                //proses controller and method
                self::contentToRender($args_uri, $controller_method);
            }
        }else{
            $run_fn=self::$index;
            if($num_call === $run_fn) {
                echo json_encode(['message'=>'Not Found']);
               // require "view/404.html";
                exit();
            }
            // //echo $controller_method;
           
        }
    }
    private function prosesEndPointFn($end_point_fn)
    {
        $explode_fn=explode("/", $end_point_fn);
        $num_component_fn=count($explode_fn);
        $end_point=$explode_fn[0];
        $num_args_fn=$num_component_fn-1;
        return array('end_point_fn'=>$end_point, 'num_args_fn'=>$num_args_fn);
    }
    public static function countRoute($method){
        $a="Router::".$method;
        $file1 = fopen("Route/Web.php","r");
        $contents = fread($file1, filesize("Route/Web.php"));
        fclose($file1);
        $arr = substr_count($contents, $a);
        return $arr;
    }
    public static function contentToRender($args_uri, $controller_method)
    {
        spl_autoload_register(function ($class) {    
            if(is_file($class.".php")){
               include $class . '.php';
            }
        });
        //$uri = self::processURI();
        // $controller = $uri['controller'];
        // $method = $uri['method'];
        // $args = $uri['args'];
        $uri=self::prosessRequest($controller_method);
        $controller=$uri['controller'];
        $method=$uri['method'];
        //var_dump($uri['controller']);
        if (class_exists($uri['controller'])) {
            //Now, the magic
            $ctrl=new $controller();
            if($method==="GET"){
                $args_uri ? $ctrl->$method(...$args_uri) : $ctrl->$method();
            }else{
                // $controllers1="Controller";
                // $controllers="\Controllers\\".$controllers1;
                // $getCont=new $controllers();
                $request=new Request();
                $args_uri ? $ctrl->$method(...$args_uri) : $ctrl->$method($request);
            }
            exit();
            // $args ? $controller::{$method}(...$args) :
            //     $controller::{$method}();
        }else{
            //var_dump($uri);
            echo "<br />Controller ".$controller." tidak ditemukan";
        }
    }
    private static function prosessRequest($controller_method){
        $explode=explode("@", $controller_method);
        $controller="\Controllers\\".$explode[0];
        $method=$explode[1];
        return array('controller'=>$controller, 'method'=>$method);
    }
    private static function getURI()
    {
        $path_info = $_SERVER['REQUEST_URI'] ?? '/';
        if(isset($_SERVER['REQUEST_URI'])){
            $path_info=$_SERVER["REQUEST_URI"];
        }else{
            $path_info="/";
        }
        return explode('/', $path_info);
    }

    private static function processURI()
    {
        //var_dump(self::getURI());
        $end_point = self::getURI()[2] ?? '';
        //var_dump("test ".$end_point);
        $numParts = count(self::getURI());
        $argsPart = [];
        for ($i = 3; $i < $numParts; $i++) {
            $argsPart[] = self::getURI()[$i] ?? '';
        }

        //Let's create some defaults if the parts are not set
        // $direct = !empty($end_point) ?
        // '\Controllers\\'.$controllerPart :
        // '\Controllers\HomeController';

        // $method = !empty($methodPart) ?
        //     $methodPart :
        //     'index';

        $args = !empty($argsPart) ?
            $argsPart :
            [];

        return [
            'end_point' => $end_point,
            'args' => $args,
            'num_args'=>count($args)
        ];
    }

}