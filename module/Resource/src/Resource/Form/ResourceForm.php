<?php
namespace Resource\Form;

//use Zend\Form\Form;
use SAC\Form\Form;

class ResourceForm extends Form
{
    public function __construct($arrTeams, $arrSalaries)
    {
        $arrTeamOptions = array();
        $arrSalaryOptions = array();

        $arrTeamOptions = array();
        foreach ($arrTeams as $objTeam) {
            $arrTeamOptions[$objTeam->teamId] = $objTeam->name;
        }

        foreach ($arrSalaries as $objSalary) {
            $arrSalaryOptions[$objSalary->salaryId] = $objSalary->grade;
        }

        parent::__construct('resource');
        $this->setAttribute('method', 'post');
        $this->add(array(
                        'name' => 'resourceId',
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
                        'name' => 'salaryGradeId',
                        'options' => array(
                                        'options' => $arrSalaryOptions,
                                        'label' => 'Salary Grade : '
                        )
        ));

        $this->add($this->_addTextInput('description', 'Description : '));

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