<?php
namespace Resource\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter,
Zend\InputFilter\Factory as InputFactory,
Zend\InputFilter\InputFilterAwareInterface,
Zend\InputFilter\InputFilterInterface;

/**
 * Resource Entity
 *
 * @ORM\Table(name="resources")
 * @ORM\Entity
 */
class ResourceEntity implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
     * @var integer
     *
     * @ORM\Column(name="resourceId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $resourceId;

    /**
     * @var integer
     *
     * @ORM\Column(name="teamId", type="integer", nullable=false)
     */
    private $teamId;

    /**
     * @var integer
     *
     * @ORM\Column(name="salaryGradeId", type="integer", nullable=false)
     */
    private $salaryGradeId;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

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
        $this->resourceId = (isset($data['resourceId'])) ? $data['resourceId'] : null;
        $this->teamId = (isset($data['teamId'])) ? $data['teamId'] : null;
        $this->salaryGradeId = (isset($data['salaryGradeId'])) ? $data['salaryGradeId'] : null;
        $this->description = (isset($data['description'])) ? $data['description'] : null;
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
                            'name'       => 'resourceId',
                            'required'   => true,
                            'filters' => array(
                                            array('name'    => 'Int'),
                            ),
            )));

            $fieldsWithInt = array(
                            'teamId',
                            'salaryGradeId',
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