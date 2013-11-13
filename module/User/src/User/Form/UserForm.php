<?php
namespace User\Form;

//use Zend\Form\Form;
use SAC\Form\Form;

class UserForm extends Form
{
	public function __construct($arrTeams, $arrResources, $objFinanceSettings)
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

		$this->add(array(
				'name' => 'password',
				'attributes' => array(
						'type'  => 'password',
						'placeholder' => 'Enter password'
				),
				'options' => array(
						'label' => 'Password : '
				),
		));
		
		$this->add(array(
				'name' => 'passwordConfirmation',
				'attributes' => array(
						'type'  => 'password',
						'placeholder' => 'Enter password again'
				),
				'options' => array(
						'label' => 'Reenter Password : '
				),
		));
		
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
		$this->add($this->_addTextInput('sssContribution', 'SSS - employer contribution : ', $objFinanceSettings->sssContribution));
		$this->add($this->_addTextInput('eccContribution', 'ECC - employer contribution : ', $objFinanceSettings->eccContribution));
		$this->add($this->_addTextInput('phicContribution', 'PHIC - employer contribution : ', $objFinanceSettings->phicContribution));
		$this->add($this->_addTextInput('hmdfContribution', 'HDMF - employer contribution : ', $objFinanceSettings->hmdfContribution));
		$this->add($this->_addTextInput('medicare', 'Medicare : ', $objFinanceSettings->medicare));
		$this->add($this->_addTextInput('pamperDayBenefit', 'Pamper Day Benefit : ', $objFinanceSettings->pamperDayBenefit));
		$this->add($this->_addTextInput('programsAndEvents', 'Fun/HR Dev Programs & Events   : ', $objFinanceSettings->programsAndEvents));
		$this->add($this->_addTextInput('equipmentAndFurniture', 'Equipment and furniture depreciation : ', $objFinanceSettings->equipmentAndFurniture));
		$this->add($this->_addTextInput('softwareAndRelated', 'Software Licenses & related maintenance : ', $objFinanceSettings->softwareAndRelated));
		$this->add($this->_addTextInput('bandwidth', 'Bandwidth : ', $objFinanceSettings->bandwidth));
		$this->add($this->_addTextInput('rentAndUtilities', 'Rent, A/C & Utilities : ', $objFinanceSettings->rentAndUtilities));
		$this->add($this->_addTextInput('suppliesAndSharedServices', 'Office supplies & Shared Services (Security, HR, Admin) : ', $objFinanceSettings->suppliesAndSharedServices));
		
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