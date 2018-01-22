<?php

    class Database{

        public $host = DB_HOST;
        public $user = DB_USER;
        public $pass = DB_PASS;
        public $name = DB_NAME;

        public $link;
        public $error;

        public function __construct(){
            $this->connectDB();
        }

        private function connectDB(){
            $this->link = new mysqli($this->host,$this->user,$this->pass,$this->name);

            if (!$this->link){
                $this->error = "Connection Failed.".$this->link->connect_error;
                return false;
            }
        }

        public function insert($query){
            $insert = $this->link->query($query) or die($this->link->error.__LINE__);
            if ($insert){
                return $insert;
            }else{
                return false;
            }
        }

        public function select($query){
            $select  = $this->link->query($query) or die($this->link->error.__LINE__);
            if ($select->num_rows > 0 ){
                return $select;
            }else{
                return false;
            }
        }

        public function delete($query){
            $delete  = $this->link->query($query) or die($this->link->error.__LINE__);
            if ($delete){
                return $delete;
            }else{
                return false;
            }
        }

    }

?>