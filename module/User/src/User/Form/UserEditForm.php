<?php
namespace User\Form;

use SAC\Form\Form;

class UserEditForm extends Form
{
	public function __construct($arrTeams, $arrResources)
	{
		$arrTeamOptions = array();
		foreach ($arrTeams as $objTeam) {
			$arrTeamOptions[$objTeam->teamId] = $objTeam->name;
		}
		
		$arrResourceOptions = array();
		foreach ($arrResources as $objResource) {
			$arrResourceOptions[$objResource->resourceId] = $objResource->description;
		}
		
		// we want to ignore the name passed
		parent::__construct('user');
		$this->setAttribute('method', 'post');
		$this->add(array(
				'name' => 'user_id',
				'attributes' => array(
						'type'  => 'hidden',
				),
		));

		$this->add(array(
				'type' => 'Zend\Form\Element\Select',
				'name' => 'teamId',
				'options' => array(
						'options' => $arrTeamOptions,
						'label' => 'Team : '
				)
		));
		
		$this->add(array(
				'type' => 'Zend\Form\Element\Select',
				'name' => 'resourceId',
				'options' => array(
						'options' => $arrResourceOptions,
						'label' => 'Resource : '
				)
		));
		
		$this->add($this->_addTextInput('username', 'Username : '));

		$this->add($this->_addTextInput('title', 'Title : '));
		$this->add($this->_addTextInput('firstName', 'First Name : '));
		$this->add($this->_addTextInput('lastName', 'Last Name : '));
		$this->add($this->_addTextInput('email', 'Email : '));
		$this->add($this->_addTextInput('address', 'Address : '));
		
		//salary related
		$this->add($this->_addTextInput('basicSalary', 'Full Month Basic Salary : '));
		$this->add($this->_addTextInput('deMinimis', 'De minimis Benefit : '));
		$this->add($this->_addTextInput('transportAllowance', 'Transport Allowance : '));
		$this->add($this->_addTextInput('mealAllowance', 'Meal Allowance : '));
		$this->add($this->_addTextInput('nightDifferential', 'Actual Night Differential : '));
		$this->add($this->_addTextInput('overtimeAndHolidayPay', 'Representation Allowance, OT & Holiday Pay (grossed up) : '));
		$this->add($this->_addTextInput('nthMonthPay', '13th month - mandatory bonus : '));
		$this->add($this->_addTextInput('sssContribution', 'SSS - employer contribution : '));
		$this->add($this->_addTextInput('eccContribution', 'ECC - employer contribution : '));
		$this->add($this->_addTextInput('phicContribution', 'PHIC - employer contribution : '));
		$this->add($this->_addTextInput('hmdfContribution', 'HDMF - employer contribution : '));
		$this->add($this->_addTextInput('medicare', 'Medicare : '));
		$this->add($this->_addTextInput('pamperDayBenefit', 'Pamper Day Benefit : '));
		$this->add($this->_addTextInput('programsAndEvents', 'Fun/HR Dev Programs & Events   : '));
		$this->add($this->_addTextInput('equipmentAndFurniture', 'Equipment and furniture depreciation : '));
		$this->add($this->_addTextInput('softwareAndRelated', 'Software Licenses & related maintenance : '));
		$this->add($this->_addTextInput('bandwidth', 'Bandwidth : '));
		$this->add($this->_addTextInput('rentAndUtilities', 'Rent, A/C & Utilities : '));
		$this->add($this->_addTextInput('suppliesAndSharedServices', 'Office supplies & Shared Services (Security, HR, Admin) : '));
		
		$this->add(array(
				'type' => 'Zend\Form\Element\Radio',
				'name' => 'available',
				'options' => array(
						'value_options' => array('1'=>'Yes', '0'=>'No'),
						'label' => 'Available : '
				),
				'attributes' => array(
						'value' => '1',
				),
		));
		
		$this->add(array(
				'type' => 'Zend\Form\Element\Radio',
				'name' => 'deleted',
				'options' => array(
						'value_options' => array('1'=>'Yes', '0'=>'No'),
						'label' => 'Deleted : '
				),
				'attributes' => array(
						'value' => '0',
				),
		));

		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
						'type'  => 'submit',
						'value' => 'Go',
						'id' => 'submitbutton',
				),
				
		));
	}
}