<?php
namespace Salary\Form;

//use Zend\Form\Form;
use SAC\Form\Form;

class SalaryForm extends Form
{
	public function __construct()
	{
		
		parent::__construct('salary');
		$this->setAttribute('method', 'post');
		$this->add(array(
				'name' => 'salaryId',
				'attributes' => array(
						'type'  => 'hidden',
				),
		));
		
		$textFields = array(
		                'grade'           => 'Salary Grade',
		                'band'           => 'Band',
		                'tier'          => 'Tier',
		                'salaryMinimum'          => 'Salary Minimum',
		                'midpoint'                  => 'Midpoint',
		                'salaryMaximum'          => 'Salary Maximum',
		                'mealAllowance'         => 'Meal Allowance',
		                'transportationAllowance'     => 'Transportation Allowance',
		                'variableAllowance'        => 'Variable Allowance and Honorarium ',
		                'nightDifferential'                 => 'Night Differential',
		                'overtimeHolidayPremium'          => 'OT and Holiday Premium',
		                'vacationLeaves'                 => 'Vacation Leave',
		                'sickLeaves'          => 'Sick Leave',
		);
		
		foreach ($textFields as $name => $label) {
		    $this->add(array(
		                    'name' => $name,
		                    'type' => 'Text',
		                    'attributes' => array(
		                                    'id' => $name,
		                                    'required' => 'required',
		                                    'class' => 'span10'
		                    ),
		                    'options' => array(
		                                    'label' => $label,
		                    ),
		    ));
		}

		$this->add(array(
				'type' => 'Zend\Form\Element\Radio',
				'name' => 'monthPay',
				'options' => array(
						'value_options' => array(
							'1' => 'Yes',
							'0' => 'No',
						),
						'label' => '13th Month Pay : '
				),
				'attributes' => array(
						'value' => '1',
		                'class' => 'span10'
				)
		));
		
		$this->add(array(
				'type' => 'Zend\Form\Element\Radio',
				'name' => 'creditsAccruedPerHour',
				'options' => array(
						'value_options' => array(
								'1' => 'Yes',
								'0' => 'No',
						),
						'label' => 'In Lieu Credits Accrued Per Hour : '
				),
				'attributes' => array(
						'value' => '1',
		                'class' => 'span10'
				)
		));		

		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
						'type'  => 'submit',
						'value' => 'Save',
						'id' => 'submitbutton',
		                'class' => 'btn btn-sa-green'
				),
		));
	}
}