<?php
namespace Finance\Form;

use SAC\Form\Form;

class FinanceForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('finance');

        $this->setAttribute('method', 'post');

        $textFields = array(
            'sssContribution'           => 'SSS Contribution',
            'eccContribution'           => 'ECC Contribution',
            'phicContribution'          => 'PHIC Contribution',
            'hmdfContribution'          => 'HMDF Contribution',
            'medicare'                  => 'Medicare',
            'pamperDayBenefit'          => 'Pamper Day Benefit',
            'programsAndEvents'         => 'Fun/HR Dev Programs and Events',
            'equipmentAndFurniture'     => 'Equipement and Furniture Depreciation',
            'softwareAndRelated'        => 'Software Licenses and Related Maintenance',
            'bandwidth'                 => 'Bandwidth',
            'rentAndUtilities'          => 'Rent, A/C and Utilities',
            'suppliesAndSharedServices' => 'Office Supplies and Shared Services (Security, HR, Admin)',
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
            'name' => 'financeId',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'submit',
            'type'  => 'submit',
            'attributes' => array(
                'value' => 'Save',
                'class' => 'btn btn-sa-orange'
            ),
        ));
    }
}
