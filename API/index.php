<?php
require_once "database/Database.php";
require_once "api/record.php";
require_once "api/appointment.php";
require_once "api/users.php";

$url = $_SERVER['REQUEST_URI']; 
$url = explode('/', $url);



header('Access-control-Allow-Origin: Application/Json');
header('content-type: Application/Json');


//print_r($url);die;
//echo $url[4];

if($url[4] == "v1")
{
    //record
    if($url[5]=="record")
    {

        $record = new record();
        if($url[6]=="all")
        {
            $data = $record->all();
           $res = [
               'status'=>'200',
               'data'=>$data

           ];
        echo json_encode($res);


        }
        elseif($url[6]=="add")
        {
           header('Access-Control-Allow-Methods:POST');
           $data = file_get_contents("php://input");
           $data_de = json_decode($data,true);
           $res = $record->add($data_de);
           if(isset($res))
           {
               http_response_code(201);
            $res = [
                'status'=>'201',
                'msj'=>'Success'
            ];
           }
           else
           {
            http_response_code(400);

            $res = [
                'status'=>'400',
                'msj'=>'Error'
            ];
           }

          echo json_encode($res);
        }
        elseif($url[6]=="update")
        {
            header('Access-Control-Allow-Methods: PUT');
            $data = file_get_contents("php://input");
            $data_de = json_decode($data,true);
            $id = [ "id" => $data_de['id']];
            $data = $data_de["record"];

           $res = $record->update($data,$id);

            if($res)
           {
            http_response_code(201);

            $res = [
                'status'=>'201',
                'msj'=>'Success'
            ];
           }
           else
           {  http_response_code(400);

            $res = [
                'status'=>'400',
                'msj'=>'Error'
            ];
           }
          echo json_encode($res);
        }
        
        elseif($url[6]=="delete")
        {
            header('Access-Control-Allow-Methods: DELETE');
            $data = file_get_contents("php://input");
            $data_de = json_decode($data,true);
            $id = [ "id" => $data_de['id'] ];
           $res = $record->delete($id);

            
            if(isset($res))
           {
            $res = [
                'status'=>'201',
                'msj'=>'Success'
            ];
           }
           else
           {
            $res = [
                'status'=>'400',
                'msj'=>'Error'
            ];
           }
          echo json_encode($res);
        }
        
        


    }
    
   
}

if($url[4] == "v1")
{
    //appointment
    if($url[5]=="appointment")
    {

        $appointment = new appointment();
        if($url[6]=="all")
        {
            $data = $appointment->all();
           $res = [
               'status'=>'200',
               'data'=>$data

           ];
        echo json_encode($res);


        }
        elseif($url[6]=="add")
        {
           header('Access-Control-Allow-Methods:POST');
           $data = file_get_contents("php://input");
           $data_de = json_decode($data,true);
           $res = $appointment->add($data_de);
           if(isset($res))
           {
               http_response_code(201);
            $res = [
                'status'=>'201',
                'msj'=>'Success'
            ];
           }
           else
           {
            http_response_code(400);

            $res = [
                'status'=>'400',
                'msj'=>'Error'
            ];
           }

          echo json_encode($res);
        }
        elseif($url[6]=="update")
        {
            header('Access-Control-Allow-Methods: PUT');
            $data = file_get_contents("php://input");
            $data_de = json_decode($data,true);
            $id = [ "id" => $data_de['id']];
            $data = $data_de["appointment"];

           $res = $appointment->update($data,$id);

            if($res)
           {
            http_response_code(201);

            $res = [
                'status'=>'201',
                'msj'=>'Success'
            ];
           }
           else
           {  http_response_code(400);

            $res = [
                'status'=>'400',
                'msj'=>'Error'
            ];
           }
          echo json_encode($res);
        }
        
        elseif($url[6]=="delete")
        {
            header('Access-Control-Allow-Methods: DELETE');
            $data = file_get_contents("php://input");
            $data_de = json_decode($data,true);
            $id = [ "id" => $data_de['id'] ];
           $res = $appointment->delete($id);

            
            if(isset($res))
           {
            $res = [
                'status'=>'201',
                'msj'=>'Success'
            ];
           }
           else
           {
            $res = [
                'status'=>'400',
                'msj'=>'Error'
            ];
           }
          echo json_encode($res);
        }
        
        


    }
    
}


