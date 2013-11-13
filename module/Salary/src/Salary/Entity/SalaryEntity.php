<?php
namespace Salary\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter,
    Zend\InputFilter\Factory as InputFactory,
    Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilterInterface;

/**
 * Salary Entity
 *
 * @ORM\Table(name="salaries")
 * @ORM\Entity
 */
class SalaryEntity implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
     * @var integer
     *
     * @ORM\Column(name="salaryId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $salaryId;

    /**
     * @var string
     *
     * @ORM\Column(name="grade", type="string", nullable=false)
     */
    private $grade;

    /**
     * @var string
     *
     * @ORM\Column(name="band", type="string", nullable=false)
     */
    private $band;

    /**
     * @var integer
     *
     * @ORM\Column(name="tier", type="integer", nullable=false)
     */
    private $tier;

    /**
     * @var float
     *
     * @ORM\Column(name="salaryMinimum", type="decimal", nullable=false)
     */
    private $salaryMinimum;

    /**
     * @var float
     *
     * @ORM\Column(name="midpoint", type="decimal", nullable=false)
     */
    private $midpoint;

    /**
     * @var float
     *
     * @ORM\Column(name="salaryMaximum", type="decimal", nullable=false)
     */
    private $salaryMaximum;

    /**
     * @var float
     *
     * @ORM\Column(name="mealAllowance", type="decimal", nullable=true)
     */
    private $mealAllowance;

    /**
     * @var float
     *
     * @ORM\Column(name="transportationAllowance", type="decimal", nullable=true)
     */
    private $transportationAllowance;

    /**
     * @var float
     *
     * @ORM\Column(name="variableAllowance", type="decimal", nullable=true)
     */
    private $variableAllowance;

    /**
     * @var float
     *
     * @ORM\Column(name="nightDifferential", type="decimal", nullable=true)
     */
    private $nightDifferential;

    /**
     * @var float
     *
     * @ORM\Column(name="overtimeHolidayPremium", type="decimal", nullable=true)
     */
    private $overtimeHolidayPremium;

    /**
     * @var float
     *
     * @ORM\Column(name="monthPay", type="decimal", nullable=true)
     */
    private $monthPay;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="vacationLeaves", type="integer", nullable=true)
     */
    private $vacationLeaves;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="sickLeaves", type="integer", nullable=true)
     */
    private $sickLeaves;
    
    /**
     * @var float
     *
     * @ORM\Column(name="creditsAccruedPerHour", type="decimal", nullable=true)
     */
    private $creditsAccruedPerHour;

    /**
     * Magic getter to expose protected properties.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
        if (isset($this->$property)) {
            return $this->$property;
        }
    }

    /**
     * Magic setter to save protected properties.
     *
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value)
    {
        $this->$property = $value;
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function exchangeArray($data = array()) 
    {
        $this->salaryId = (isset($data['salaryId'])) ? $data['salaryId'] : null;
        $this->grade = (isset($data['grade'])) ? $data['grade'] : null;
        $this->band = (isset($data['band'])) ? $data['band'] : null;
        $this->tier = (isset($data['tier'])) ? $data['tier'] : null;
        $this->salaryMinimum = (isset($data['salaryMinimum'])) ? $data['salaryMinimum'] : null;
        $this->midpoint = (isset($data['midpoint'])) ? $data['midpoint'] : null;
        $this->salaryMaximum = (isset($data['salaryMaximum'])) ? $data['salaryMaximum'] : null;
        $this->mealAllowance = (isset($data['mealAllowance'])) ? $data['mealAllowance'] : null;
        $this->transportationAllowance = (isset($data['transportationAllowance'])) ? $data['transportationAllowance'] : null;
        $this->variableAllowance = (isset($data['variableAllowance'])) ? $data['variableAllowance'] : null;
        $this->nightDifferential = (isset($data['nightDifferential'])) ? $data['nightDifferential'] : null;
        $this->overtimeHolidayPremium = (isset($data['overtimeHolidayPremium'])) ? $data['overtimeHolidayPremium'] : null;
        $this->monthPay = (isset($data['monthPay'])) ? $data['monthPay'] : null;
        $this->vacationLeaves = (isset($data['vacationLeaves'])) ? $data['vacationLeaves'] : null;
        $this->sickLeaves = (isset($data['sickLeaves'])) ? $data['sickLeaves'] : null;
        $this->creditsAccruedPerHour = (isset($data['creditsAccruedPerHour'])) ? $data['creditsAccruedPerHour'] : null;
    }
 
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
 
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'       => 'salaryId',
                'required'   => true,
                'filters' => array(
                    array('name'    => 'Int'),
                ),
            )));

            $fieldsWithInt = array(
                'salaryMinimum',
                'midpoint',
                'salaryMaximum',
            );

            foreach ($fieldsWithInt as $field) {
                $inputFilter->add($factory->createInput(array(
                    'name'     => $field,
                    'required' => true,
                    'validators' => array(
                        array('name'    => 'Int'),
                    ),
                )));
            }

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}