<?php
use Dcblogdev\PdoWrapper\Database;

class appointment {

    public $db;
    public function __construct(){
        $options=[
            'username'=>'root',
            'database'=>'lab',
            'password'=>'',
            'type'=>'mysql',
            'charset'=>'utf8',
            'host'=>'localhost',
            'port'=>'3306'

        ];
            $this->db = new Database($options);
    }
    public function all(){
        echo"all";
        $data = $this->db->rows("SELECT * FROM appointment");
        return $data;

    }
    public function add($data){
        echo"add";
        $data = $this->db->insert('appointment', $data);
        return $data;

    }
    public function update($data,$id){
        echo"update";
        $data = $this->db->update('appointment',$data,$id);
        return $data;

    }

    public function delete($id){
        echo"delete";
        $data = $this->db->delete('appointment',$id);
        return $data;
    }
   

}
