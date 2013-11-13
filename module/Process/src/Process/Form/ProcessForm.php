<?php
namespace Process\Form;

use SAC\Form\Form;
use Process\Model;

class ProcessForm extends Form
{
	
    public function __construct($arrTeams)
    {
    	//var_dump($arrSelectedTeams);
        parent::__construct('process');
        
    	foreach ($arrTeams as $objTeam) {
    		$arrOptions[$objTeam->teamId] = $objTeam->name;
    	}

        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');
        $this->add(array(
            'name' => 'processId',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        
        /*$this->add(array(
        		'type' => 'Zend\Form\Element\Select',
        		'name' => 'userId',
        		'options' => array(
        				'options' => $arrOptions,
        				'label' => 'User'
        		)
        ));*/

        $this->add($this->_addTextInput('name', 'Process Name : '));
        $this->add($this->_addTextInput('clientName', 'Client Name : '));
        $this->add($this->_addTextInput('contactPerson', 'Contact Person : '));
        $this->add($this->_addTextInput('contactEmail', 'Contact Email : '));
        $this->add($this->_addTextInput('contactNumber', 'Contact Number : '));
        $this->add($this->_addTextInput('owner', 'Owner : '));
        $this->add($this->_addTextInput('marginRate', 'Margin Rate (%): '));
        
        $this->add(array(
        		'type' => 'Zend\Form\Element\Select',
        		'name' => 'status',
        		'options' => array(
        				'value_options' => array(
        						'0' => 'Locked',
        						'1' => 'In Progress',
        						'2' => 'Complete',
        				),
        				'label' => 'Status : '
        		),
        		'attributes' => array(
        				'value' => '1',
        		),
        ));
        
        //$this->add($this->_addTextInput('teams', 'Teams : '));
        $this->add(array(
             'type' => 'Zend\Form\Element\MultiCheckbox',
             'name' => 'teams',
             'options' => array(
                     'label' => 'Choose Teams',
                     'value_options' => $arrOptions,
             ),
			'attributes' => array(
				//'value' => $arrSelectedTeams,		
					//'value' => array('1', '2'),
			),
        ));
        
        
        $this->add($this->_addTextInput('deliverables', 'Deliverables : '));
        
        $this->add($this->_addTextAreaInput('overview', '<span class="processLabels">I. Overview </span>'));
        $this->add($this->_addTextAreaInput('scope', '<br/><span class="processLabels">II. Scope </span>'));
        $this->add($this->_addTextAreaInput('outOfScope', '<br/><span class="processLabels">III. Out of Scope </span>'));
        $this->add($this->_addTextAreaInput('metrics', '<br/><span class="processLabels">IV. Metrics </span>'));
        $this->add($this->_addTextAreaInput('itResources', '<br/><span class="processLabels">V. Standard IT Resources </span>'));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
        
        return $this;
    }
    
    public function setServiceLocator(ServiceLocator $sl)
    {
    	$this->serviceLocator = $sl;
    }
    
    public function getServiceLocator()
    {
    	return $this->serviceLocator;
    }
    
    public function populateValues($data)
    {
    	foreach($data as $key=>$row)
    	{
    		if (is_array(@json_decode($row))){
    			$data[$key] =   new \ArrayObject(\Zend\Json\Json::decode($row), \ArrayObject::ARRAY_AS_PROPS);
    		}
    	}
    
    	parent::populateValues($data);
    }
}