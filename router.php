<?php

class Router
{

    static public function parse($url, $request)
    {
        $url = trim($url);

        if ($url == "/mvc/")
        {
            $request->controller = "tasks";
            $request->action = "index1";
            $request->params = [];
        }
        else
        {   
            // echo "URI: $url <br>";
            $explode_url = explode('/', $url);
            // print_r($explode_url);
            $explode_url = array_slice($explode_url, 2);
            // print_r($explode_url);
            $request->controller = $explode_url[0];
            $request->action = $explode_url[1];
            $request->params = array_slice($explode_url, 2);
        }

    }
}
?>