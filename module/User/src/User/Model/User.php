<?php
namespace User\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

use Zend\Form\Annotation;

class User
{
    public $user_id;
    public $teamId;
    public $resourceId;
    public $username;
    public $password;
    public $firstName;
    public $lastName;
    public $address;
    public $email;
    public $title;
    public $hiringDate;
    public $state;
    public $basicSalary;
    public $deMinimis;
    public $transportAllowance;
    public $mealAllowance;
    public $nightDifferential;
    public $overtimeAndHolidayPay;
    public $nthMonthPay;
    public $sssContribution;
    public $eccContribution;
    public $phicContribution;
    public $hmdfContribution;
    public $medicare;
    public $pamperDayBenefit;
    public $programsAndEvents;
    public $equipmentAndFurniture;
    public $softwareAndRelated;
    public $bandwidth;
    public $rentAndUtilities;
    public $suppliesAndSharedServices;
    public $available;
    public $deleted;
    
    protected $inputFilter;
    private $_dbAdapter;

    public function exchangeArray($data)
    {
    	$arrClassVars = get_class_vars(__CLASS__);
    	
    	foreach ($arrClassVars as $strKey => $strValue) {
    		if ('inputFilter' != $strKey && '_dbAdapter' != $strKey ) {
				$this->$strKey  = (isset($data[$strKey])) ? $data[$strKey] : null;
    		}
    	}
    	
        /*$this->user_id     = (isset($data['user_id'])) ? $data['user_id'] : null;
        $this->teamId     = (isset($data['teamId'])) ? $data['teamId'] : null;
        $this->username = (isset($data['username'])) ? $data['username'] : null;
        $this->password  = (isset($data['password'])) ? $data['password'] : null;
        $this->firstName  = (isset($data['firstName'])) ? $data['firstName'] : null;
        $this->lastName  = (isset($data['lastName'])) ? $data['lastName'] : null;
        $this->address  = (isset($data['address'])) ? $data['address'] : null;*/
    }
    
    public function getArrayCopy()
    {
    	return get_object_vars($this);
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
    	throw new \Exception("Not used");
    }
    
    public function getInputFilter()
    {
    	if (!$this->inputFilter) {
    		$inputFilter = new InputFilter();
    		$factory     = new InputFactory();
    
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'teamId',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'Int'),
    				),
    		)));
    
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'username',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'StringLength',
    								'options' => array(
    										'encoding' => 'UTF-8',
    										'min'      => 1,
    										'max'      => 100,
    								),
    						),
    						/*array(
    								'name' => 'Db\NoRecordExists',
    								'options' => array(
	    								'table' => 'users',
	    								'field' => 'username',
    										'adapter' => $this->getDbAdapter(),
    								),
    						),*/
    				),
    		)));
    		
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'password',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'StringLength',
    								'options' => array(
    										'encoding' => 'UTF-8',
    										'min'      => 1,
    										'max'      => 16,
    								),
    						),
    				),
    		)));
    		
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'passwordConfirmation',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'StringLength',
    								'options' => array(
    										'encoding' => 'UTF-8',
    										'min'      => 1,
    										'max'      => 16,
    								),
    						),
    						array(
    								'name'    => 'identical',
    								'options' => array(
    										'token' => 'password',
    								),
    						),
    				),
    		)));
    
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'firstName',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'StringLength',
    								'options' => array(
    										'encoding' => 'UTF-8',
    										'min'      => 1,
    										'max'      => 100,
    								),
    						),
    				),
    		)));
    		
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'lastName',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'StringLength',
    								'options' => array(
    										'encoding' => 'UTF-8',
    										'min'      => 1,
    										'max'      => 100,
    								),
    						),
    				),
    		)));
    
    		$this->inputFilter = $inputFilter;
    	}
    
    	return $this->inputFilter;
    }
    
    public function setDbAdapter($dbAdapter) 
    {
    	$this->_dbAdapter = $dbAdapter;
    }
    
    public function getDbAdapter() 
    {
    	return $this->_dbAdapter;
    }
}