<?php
namespace User\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Crypt\Password\Bcrypt;

class UserTable
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

    public function getUser($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('user_id' => $id));
        $row = $rowset->current();
        if (!$row) {
        	//add error handling
            //throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveUser(User $user)
    {
    	$arrClassVars = get_class_vars(get_class($user));
    	
    	foreach ($arrClassVars as $strKey => $strValue) {
    		if ('inputFilter' != $strKey && '_dbAdapter' != $strKey) { //exclude some
    			$data[$strKey] = $user->$strKey;
    		}
    	}

        $id = (int)$user->user_id;
        if ($id == 0) {	
        	$bcrypt = new Bcrypt;
        	$bcrypt->setCost(14);
        	$data['password'] = $bcrypt->create($user->password);//include password
        	
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUser($id)) {
                $this->tableGateway->update($data, array('user_id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteUser($id)
    {
        $this->tableGateway->delete(array('user_id' => $id));
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