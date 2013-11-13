<?php
namespace Process\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

use Zend\Form\Annotation;

class Process implements InputFilterAwareInterface
{
    public $processId;
    public $parentId;
    public $userId;
    public $name;
    public $status;
    public $clientName;
    public $contactPerson;
    public $contactEmail;
    public $contactNumber;
    public $owner;
    public $teams;
    public $lastUpdateDate;
    public $deliverables;
    public $overview;
    public $scope;
    public $outOfScope;
    public $metrics;
    public $itResources;
    public $marginRate;
    public $costPerHour;
    public $costPerStep;
    public $dailyRate;
    public $costInPesos;
    public $totalInPhp;
    public $totalInDollars;
    
    protected $inputFilter;

    public function exchangeArray($data)
    {
        $arrClassVars = get_class_vars(__CLASS__);
    	
    	foreach ($arrClassVars as $strKey => $strValue) {
    		if ('marginRate' == $strKey ||'costPerHour' == $strKey ||'costPerStep' == $strKey ||'dailyRate' == $strKey ||'costInPesos' == $strKey ||
    				'totalInPhp' == $strKey ||'totalInDollars' == $strKey) {
    			$this->$strKey  = (isset($data[$strKey])) ? $data[$strKey] : 0;
    		}
    		else if ('inputFilter' != $strKey && '_dbAdapter' != $strKey ) {
				$this->$strKey  = (isset($data[$strKey])) ? $data[$strKey] : null;
    		}
    	}
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
    				'name'     => 'userId',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'Int'),
    				),
    		)));
    
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'name',
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
    				'name'     => 'clientName',
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
    				'name'     => 'contactPerson',
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
    
    private function _inputFilter($field) {
    	
    }
}