<?php
namespace Process\Model;

use Zend\Db\TableGateway\TableGateway;

class StepTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getStep($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('stepId' => $id));
        $row = $rowset->current();
        if (!$row) {
        	//add error handling
            //throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveStep(Step $step)
    {
    	$arrClassVars = get_class_vars(get_class($step));
    	 
    	foreach ($arrClassVars as $strKey => $strValue) {
    		$data[$strKey] = $step->$strKey;
    	}

        $id = (int)$step->stepId;
        if ($id == 0) { //new step
            $this->tableGateway->insert($data);
            return $this->tableGateway->lastInsertValue; //return id
        } else {
        	unset($data['stepId']);
        	
        	$this->tableGateway->insert($data);
        	return $this->tableGateway->lastInsertValue; //return id
        	
            /*if ($this->getStep($id)) {
                $this->tableGateway->update($data, array('stepId' => $id));
            } else {
            	//add error handling
                //throw new \Exception('Form id does not exist');
            }*/
        }
    }
    
    public function updateStep(Step $step)
    {
    	$arrClassVars = get_class_vars(get_class($step));
    	
    	foreach ($arrClassVars as $strKey => $strValue) {
    		$data[$strKey] = $step->$strKey;
    	}
    	
    	$id = (int)$step->stepId;
    	
    	if ($this->getStep($id)) {
    	 $this->tableGateway->update($data, array('stepId' => $id));
    	} else {
    	//add error handling
    	//throw new \Exception('Form id does not exist');
    	}
    }

    public function deleteStep($id)
    {
        $this->tableGateway->delete(array('stepId' => $id));
    }
    
    public function fetchAllByField($strField, $strValue)
    {
    	$arrResults = $this->tableGateway->select(array($strField => $strValue));
    	if (!$arrResults) {
    		//add error handling
    		//throw new \Exception("Could not find row $strValue");
    	}
    	return $arrResults;
    }
    
    public function deleteAllByField($strField, $strValue)
    {
    	$arrResults = $this->tableGateway->delete(array($strField => $strValue));
    }
}