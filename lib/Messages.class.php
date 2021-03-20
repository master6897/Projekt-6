<?php

class Messages{
    private $errors = array();
    private $num = 0;
    
    public function addError($messages){
        $this->errors[] = $messages;
        $this->num++;
    }
    public function isEmpty(){
        return $this->num == 0;
    }
    public function isError(){
        return count ($this->errors) > 0;
    }
    public function getErrors(){
        return $this->errors;
    }
    public function clearErros(){
        $this->erros = array();
        $this->num = 0;
    }
}

