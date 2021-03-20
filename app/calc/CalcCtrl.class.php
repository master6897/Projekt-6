<?php

require_once $config->root_path.'/lib/smarty/Smarty.class.php';
require_once $config->root_path.'/app/calc/CalcForm.class.php';
require_once $config->root_path.'/app/calc/CalcResult.class.php';
require_once $config->root_path.'/lib/Messages.class.php';

class CalcCtrl{
   private $messages;
   private $form;
   private $result;
   
   public function __construct() {
       $this->messages = new Messages();
       $this->form = new CalcForm();
       $this->result = new CalcResult();
   }
   
   public function getParams(){
        $this->form->credits = isset($_REQUEST['credits'])? $_REQUEST['credits']: null;
        $this->form->years = isset($_REQUEST['years'])? $_REQUEST['years']: null;
        $this->form->percentage = isset($_REQUEST['percent'])?$_REQUEST['percent']: null ;
   }
   
   public function validate(){
       if(!(isset($this->form->credits) && isset($this->form->years) && isset($this->form->percentage))){
        return false;
    }
    if($this->form->credits == ""){
        $this->messages->addError("Nie podano wartości kredytu");
    }
    if($this->form->years == ""){
        $this->messages->addError("Nie podano na ile lat");
    }
    if($this->form->percentage == ""){
        $this->messages->addError("Nie podano na jakim oprocentowaniu");
    }

    //walidacja danych
    if(empty($this->messages->isError())){
        if(! is_numeric($this->form->credits)){
            $this->messages->addError("Kredyt musi być liczbą!");
        }
        if(! is_numeric($this->form->years)){
            $this->messages->addError("Lata musza być liczbą!");
        }
        if(! is_numeric($this->form->percentage)){
            $this->messages->addError("Oprocentowanie musi być liczbą!");
        }
    }
    
    return !$this->messages->isError();
   }
   
   public function calc(){
       $this->getParams();
       
       if($this->validate()){
       
        $this->form->credits = floatval($this->form->credits);
        $this->form->years = intval($this->form->years);
        $this->form->percentage = floatval($this->form->percentage);

        $this->result->cost = $this->form->credits + ($this->form->credits*($this->form->percentage/100));
        $this->result->rata = $this->result->cost/(($this->form->years)*12);
       }
       $this->generateView();
   }
   
   public function generateView(){
       global $config;
            $smarty = new Smarty();

     $smarty->assign('config',$config);
     $smarty->assign('page_title','Kalkulator');
     $smarty->assign('page_person','Marcin Puc');
     $smarty->assign('page_localization','Jastrzębie-Zdrój');
     $smarty->assign('page_email','pucmarcin@gmail.com');
     $smarty->assign('page_phone','666-666-666');

     $smarty->assign('rata',$this->result->rata);
     $smarty->assign('cost',$this->result->cost);
     $smarty->assign('credits',$this->form->credits);
     $smarty->assign('years',$this->form->years);
     $smarty->assign('percentage',$this->form->percentage);
     $smarty->assign('messages',$this->messages);

     $smarty->display($config->root_path.'/app/calc/calc.tpl');
   }
}

