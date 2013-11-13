<?php
namespace Finance\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter,
    Zend\InputFilter\Factory as InputFactory,
    Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilterInterface;

/**
 * Finance Entity
 *
 * @ORM\Table(name="finance")
 * @ORM\Entity
 */
class FinanceEntity implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
     * @var integer
     *
     * @ORM\Column(name="financeId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $financeId;

    /**
     * @var float
     *
     * @ORM\Column(name="sssContribution", type="decimal", nullable=false)
     */
    private $sssContribution;

    /**
     * @var float
     *
     * @ORM\Column(name="eccContribution", type="decimal", nullable=false)
     */
    private $eccContribution;

    /**
     * @var float
     *
     * @ORM\Column(name="phicContribution", type="decimal", nullable=false)
     */
    private $phicContribution;

    /**
     * @var float
     *
     * @ORM\Column(name="hmdfContribution", type="decimal", nullable=false)
     */
    private $hmdfContribution;

    /**
     * @var float
     *
     * @ORM\Column(name="medicare", type="decimal", nullable=false)
     */
    private $medicare;

    /**
     * @var float
     *
     * @ORM\Column(name="pamperDayBenefit", type="decimal", nullable=false)
     */
    private $pamperDayBenefit;

    /**
     * @var float
     *
     * @ORM\Column(name="programsAndEvents", type="decimal", nullable=false)
     */
    private $programsAndEvents;

    /**
     * @var float
     *
     * @ORM\Column(name="equipmentAndFurniture", type="decimal", nullable=false)
     */
    private $equipmentAndFurniture;

    /**
     * @var float
     *
     * @ORM\Column(name="softwareAndRelated", type="decimal", nullable=false)
     */
    private $softwareAndRelated;

    /**
     * @var float
     *
     * @ORM\Column(name="bandwidth", type="decimal", nullable=false)
     */
    private $bandwidth;

    /**
     * @var float
     *
     * @ORM\Column(name="rentAndUtilities", type="decimal", nullable=false)
     */
    private $rentAndUtilities;

    /**
     * @var float
     *
     * @ORM\Column(name="suppliesAndSharedServices", type="decimal", nullable=false)
     */
    private $suppliesAndSharedServices;

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
        $this->financeId                 = isset($data['financeId'])                 ? $data['financeId']                 : null;
        $this->sssContribution           = isset($data['sssContribution'])           ? $data['sssContribution']           : null;
        $this->eccContribution           = isset($data['eccContribution'])           ? $data['eccContribution']           : null;
        $this->phicContribution          = isset($data['phicContribution'])          ? $data['phicContribution']          : null;
        $this->hmdfContribution          = isset($data['hmdfContribution'])          ? $data['hmdfContribution']          : null;
        $this->medicare                  = isset($data['medicare'])                  ? $data['medicare']                  : null;
        $this->pamperDayBenefit          = isset($data['pamperDayBenefit'])          ? $data['pamperDayBenefit']          : null;
        $this->programsAndEvents         = isset($data['programsAndEvents'])         ? $data['programsAndEvents']         : null;
        $this->equipmentAndFurniture     = isset($data['equipmentAndFurniture'])     ? $data['equipmentAndFurniture']     : null;
        $this->softwareAndRelated        = isset($data['softwareAndRelated'])        ? $data['softwareAndRelated']        : null;
        $this->bandwidth                 = isset($data['bandwidth'])                 ? $data['bandwidth']                 : null;
        $this->rentAndUtilities          = isset($data['rentAndUtilities'])          ? $data['rentAndUtilities']          : null;
        $this->suppliesAndSharedServices = isset($data['suppliesAndSharedServices']) ? $data['suppliesAndSharedServices'] : null;
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
                'name'       => 'financeId',
                'required'   => true,
                'filters' => array(
                    array('name'    => 'Int'),
                ),
            )));

            $fieldsWithInt = array(
                'sssContribution',
                'eccContribution',
                'phicContribution',
                'hmdfContribution',
                'medicare',
                'pamperDayBenefit',
                'programsAndEvents',
                'equipmentAndFurniture',
                'softwareAndRelated',
                'bandwidth',
                'rentAndUtilities',
                'suppliesAndSharedServices',
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