<?php
namespace Process\Model;

class Step
{
    public $stepId;
    public $processId;
    public $steps;
    public $details;
    public $turnaroundTime;
    public $dailyRate;
    public $costInPesos;
    public $margin;
    public $totalInPhp;
    public $totalInDollars;
    public $costPerHour;
    public $costPerStep;

    public function exchangeArray($data)
    {
        $arrClassVars = get_class_vars(__CLASS__);
        $arrFltData = array('turnaroundTime','dailyRate','costInPesos','margin','totalInPhp','totalInDollars',
        		'costPerHour','costPerStep',);
    	
    	foreach ($arrClassVars as $strKey => $strValue) {
    		if (in_array($strKey, $arrFltData)) {
    			$this->$strKey = (isset($data[$strKey])) ? $data[$strKey] : 0;
    		} else {
				$this->$strKey  = (isset($data[$strKey])) ? $data[$strKey] : null;
    		}
    	}
    }
    
    public function getArrayCopy()
    {
    	return get_object_vars($this);
    }
    
    private function _inputFilter($field) {
    	
    }
}