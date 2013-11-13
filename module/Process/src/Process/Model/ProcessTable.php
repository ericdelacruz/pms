<?php
namespace Process\Model;

use Zend\Db\TableGateway\TableGateway;

class ProcessTable
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

    public function getProcess($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('processId' => $id));
        $row = $rowset->current();

        if (!$row) {
        	//add error handling
            //throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveProcess(Process $process)
    {

        $arrClassVars = get_class_vars(get_class($process));

    	foreach ($arrClassVars as $strKey => $strValue) {
    		if ('processId' != $strKey) {
    			$data[$strKey] = $process->$strKey;
    		}
    	}
    	$data['teams'] = json_encode($data['teams']);
    	$data['lastUpdateDate'] = date('Y-m-d H:i:s');

        $id = (int)$process->processId;
        if ($id == 0) { //new process
        	//add user id
        	$data['parentId'] = 0;
        	$data['userId'] = $process->userId;
            $this->tableGateway->insert($data);

            return $this->tableGateway->lastInsertValue; //return id
        } else { //create a new version
        	$objProcess = $this->getProcess($id);
            if ($objProcess) {
            	//$data['processId'] = NULL;
            	$data['userId'] = $objProcess->userId;
            	$data['parentId'] = $objProcess->parentId;

            	if (0 == $data['parentId']) {
            		$data['parentId'] = $id;
            	}

            	$this->tableGateway->insert($data);
            	
            	return $this->tableGateway->lastInsertValue; //return id            	
            } else {
            	//add error handling
                //throw new \Exception('Form id does not exist');
            }
        }
    }
    
    public function updateProcess(Process $objProcess)
    {
    	$arrClassVars = get_class_vars(get_class($objProcess));
    	
    	foreach ($arrClassVars as $strKey => $strValue) {
    		$data[$strKey] = $objProcess->$strKey;
    	}
    	
    	$id = (int)$objProcess->processId;
    	
    	if ($this->getProcess($id)) {
	    	$this->tableGateway->update($data, array('processId' => $id));
    	} else {
    	//add error handling
    	//throw new \Exception('Form id does not exist');
    	}
    }

    public function deleteProcess($id)
    {
        $this->tableGateway->delete(array('processId' => $id));
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
}