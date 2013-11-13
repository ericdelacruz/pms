<?php
namespace Team\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter,
    Zend\InputFilter\Factory as InputFactory,
    Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilterInterface;

/**
 * Team Entity
 *
 * @ORM\Table(name="teams")
 * @ORM\Entity
 */
class TeamEntity implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
     * @var integer
     *
     * @ORM\Column(name="teamId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $teamId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="overheadCost", type="decimal", nullable=true)
     */
    private $overheadCost;

    /**
     * @var string
     *
     * @ORM\Column(name="itResources", type="string", nullable=true)
     */
    private $itResources;

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
        $this->teamId = (isset($data['teamId'])) ? $data['teamId'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->overheadCost = (isset($data['overheadCost'])) ? $data['overheadCost'] : null;
        $this->itResources = (isset($data['itResources'])) ? $data['itResources'] : null;
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
                'name'       => 'teamId',
                'required'   => true,
                'filters' => array(
                    array('name'    => 'Int'),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                            'name'       => 'name',
                            'required'   => true,
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}