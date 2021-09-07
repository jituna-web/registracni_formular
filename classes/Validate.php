<?php
class Validate{
    private $_passed = false,
            $_errors = array(),
            $_db = null;

    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    public function check ($source, $items = array()){
        foreach($items as $item => $rules) {
            foreach($rules as $rule => $rule_value){
                

                $value = trim($source[$item]);
                $item = escape($item);
                
                if ($rule === 'Požadované' && empty($value)){
                    $this->addError("{$item} je požadováno");
                } else if (!empty($value)) {
                    switch($rule){
                        case 'min';
                            if(strlen($value)< $rule_value){
                                $this ->addError("{$item} musí obsahovat minimálně {$rule_value} znaků.");

                            }
                        break;

                        case 'max';
                        if(strlen($value)< $rule_value){
                            $this ->addError("{$item} musí obsahovat maximálně {$rule_value} znaků.");

                        }     
                        break;

                        case 'matches';
                            if($value != $source[$rule_value]) {
                                $this->addError ("{$rule_value} se musí shodovat {$item}");
                            }
                        break;

                        case 'unique';
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                                if($check->count()){
                                    $this->addError("{$item} už existuje.");
                                }
                        break;
                    }
                }
            }
        }
        if (empty($this->_errors)){
             $this->_passed = true;
        }
        return $this;
    }

    private function addError($error){
        $this->_errors[] = $error;
    }
    public function errors() {
        return $this->_errors;
    }
    public function passed(){
        return $this-> _passed;
    }
}

?>