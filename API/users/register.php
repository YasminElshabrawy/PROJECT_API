<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function msg($success,$status,$message,$extra = []){
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ],$extra);
}

// INCLUDING DATABASE AND MAKING OBJECT
require __DIR__.'/classes/Database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();

// GET DATA FORM REQUEST
$data = json_decode(file_get_contents("php://input"));
$returnData = [];

// IF REQUEST METHOD IS NOT POST
if($_SERVER["REQUEST_METHOD"] != "POST"):
    $returnData = msg(0,404,'Page Not Found!');

// CHECKING EMPTY FIELDS
elseif(!isset($data->user_id) 
    || !isset($data->user_email) 
    || !isset($data->user_password)
    || empty(trim($data->user_id))
    || empty(trim($data->user_email))
    || empty(trim($data->user_password))
    ):

    $fields = ['fields' => ['user_id','user_email','user_password']];
    $returnData = msg(0,422,'Please Fill in all Required Fields!',$fields);

// IF THERE ARE NO EMPTY FIELDS THEN-
else:
    
    $user_id = trim($data->user_id);
    $user_email = trim($data->user_email);
    $user_password = trim($data->user_password);

    if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)):
        $returnData = msg(0,422,'Invalid Email Address!');
    
    elseif(strlen($user_password) < 8):
        $returnData = msg(0,422,'Your password must be at least 8 characters long!');


    else:
        try{

            $check_email = "SELECT `user_email` FROM `users` WHERE `user_email`=:user_email";
            $check_email_stmt = $conn->prepare($check_email);
            $check_email_stmt->bindValue(':user_email', $user_email,PDO::PARAM_STR);
            $check_email_stmt->execute();

            if($check_email_stmt->rowCount()):
                $returnData = msg(0,422, 'This E-mail already in use!');
            
            else:
                $insert_query = "INSERT INTO `users`(`user_id`,`user_email`,`user_password`) VALUES(:user_id,:user_email,:user_password)";

                $insert_stmt = $conn->prepare($insert_query);

                // DATA BINDING
                $insert_stmt->bindValue(':user_id', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':user_email', $user_email,PDO::PARAM_STR);
                $insert_stmt->bindValue(':user_password', password_hash($user_password, PASSWORD_DEFAULT),PDO::PARAM_STR);

                $insert_stmt->execute();

                $returnData = msg(1,201,'You have successfully registered.');

            endif;

        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }
    endif;
    
endif;

echo json_encode($returnData);
