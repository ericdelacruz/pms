<?php
namespace Process\Model;

use Zend\Db\TableGateway\TableGateway;

class StepResourceTable
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

    public function getStepResource($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('stepResourceId' => $id));
        $row = $rowset->current();
        if (!$row) {
        	//add error handling
            //throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveStepResource(StepResource $stepResource)
    {
    	$arrClassVars = get_class_vars(get_class($stepResource));
    	 
    	foreach ($arrClassVars as $strKey => $strValue) {
    		$data[$strKey] = $stepResource->$strKey;
    	}
        
        $id = (int)$stepResource->stepResourceId;
        if ($id == 0) { //new step
            $this->tableGateway->insert($data);
            return $this->tableGateway->lastInsertValue; //return id
        } else {
        	die();
            if ($this->getStepResource($id)) {
                $this->tableGateway->update($data, array('stepResourceId' => $id));
            } else {
            	//add error handling
                //throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteStepResource($id)
    {
        $this->tableGateway->delete(array('stepResourceId' => $id));
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