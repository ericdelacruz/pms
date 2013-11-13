<?php
namespace Team\Form;

//use Zend\Form\Form;
use SAC\Form\Form;

class TeamForm extends Form
{
	public function __construct()
	{
		
		parent::__construct('team');
		$this->setAttribute('method', 'post');
		$this->add(array(
				'name' => 'teamId',
				'attributes' => array(
						'type'  => 'hidden',
				),
		));
		
		$this->add($this->_addTextInput('name', 'Team Name : '));
		$this->add($this->_addTextInput('overheadCost', 'Overhead Cost : '));
		$this->add($this->_addTextInput('itResources', 'IT Resources : '));
		$this->add($this->_addTextAreaInput('itResources', 'IT Resources :'));

		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
						'type'  => 'submit',
						'value' => 'Go',
						'id' => 'submitbutton',
		                'class' => 'btn btn-sa-green'
				),
		));
	}
}