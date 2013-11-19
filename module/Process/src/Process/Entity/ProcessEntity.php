<?php
namespace Process\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter,
    Zend\InputFilter\Factory as InputFactory,
    Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilterInterface;

/**
 * Process Entity
 *
 * @ORM\Table(name="processes")
 * @ORM\Entity
 */

class ProcessEntity implements InputFilterAwareInterface
{
    protected $inputFilter;
    
    /**
     * @var Integer
     *
     * @ORM\Column(name="processId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $processId;
    
    /**
     * @var Integer
     *
     * @ORM\Column(name="parentId", type="decimal", nullable=false)
     */
    private $parentId;
    
    /**
     * @var Integer
     *
     * @ORM\Column(name="userId", type="decimal", nullable=false)
     */
    private $userId;
    
    /**
     * @var String
     *
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name;
    
    /**
     * @var Integer
     *
     * @ORM\Column(name="status", type="decimal", nullable=false)
     */
    private $status;
    
    /**
     * @var String
     *
     * @ORM\Column(name="clientName", type="string", nullable=false)
     */
    private $clientName;
    
    /**
     * @var String
     *
     * @ORM\Column(name="contactPerson", type="string", nullable=false)
     */
    private $contactPerson;
    
    /**
     * @var string
     *
     * @ORM\Column(name="contactEmail", type="string", nullable=false)
     */
    private $contactEmail;
    
    /**
     * @var String
     *
     * @ORM\Column(name="contactNumber", type="string", nullable=false)
     */
    private $contactNumber;
    
    /**
     * @var String
     *
     * @ORM\Column(name="owner", type="string", nullable=false)
     */
    private $owner;
    
    /**
     * @var String
     *
     * @ORM\Column(name="teams", type="string", nullable=false)
     */
    private $teams;
    
    /**
     * @var String
     *
     * @ORM\Column(name="lastUpdateDate", type="string", nullable=false)
     */
    private $lastUpdateDate;
    
    /**
     * @var String
     *
     * @ORM\Column(name="deliverables", type="string", nullable=false)
     */
    private $deliverables;

    /**
     * @var String
     *
     * @ORM\Column(name="overview", type="string", nullable=false)
     */
    private $overview;

    /**
     * @var String
     *
     * @ORM\Column(name="scope", type="string", nullable=false)
     */
    private $scope;

    /**
     * @var String
     *
     * @ORM\Column(name="outOfScope", type="string", nullable=false)
     */
    private $outOfScope;

    /**
     * @var String
     *
     * @ORM\Column(name="metrics", type="string", nullable=false)
     */
    private $metrics;

    /**
     * @var String
     *
     * @ORM\Column(name="itResources", type="string", nullable=false)
     */
    private $itResources;

    /**
     * @var Float
     *
     * @ORM\Column(name="marginRate", type="decimal", nullable=false)
     */
    private $marginRate;

    /**
     * @var Float
     *
     * @ORM\Column(name="costPerHour", type="decimal", nullable=false)
     */
    private $costPerHour;

    /**
     * @var Float
     *
     * @ORM\Column(name="costPerStep", type="decimal", nullable=false)
     */
    private $costPerStep;

    /**
     * @var Float
     *
     * @ORM\Column(name="dailyRate", type="decimal", nullable=false)
     */
    private $dailyRate;

    /**
     * @var Float
     *
     * @ORM\Column(name="costInPesos", type="decimal", nullable=false)
     */
    private $costInPesos;

    /**
     * @var Float
     *
     * @ORM\Column(name="totalInPhp", type="decimal", nullable=false)
     */
    private $totalInPhp;

    /**
     * @var Float
     *
     * @ORM\Column(name="totalInDollars", type="decimal", nullable=false)
     */
    private $totalInDollars;
    
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
        $this->processId                 = isset($data['processId'])          ? $data['processId']      : null;
        $this->parentId                  = isset($data['parentId'])           ? $data['parentId']       : null;
        $this->userId                    = isset($data['userId'])             ? $data['userId']         : null;
        $this->name                      = isset($data['name'])               ? $data['name']           : null;
        $this->status                    = isset($data['status'])             ? $data['status']         : null;
        $this->clientName                = isset($data['clientName'])         ? $data['clientName']     : null;
        $this->contactPerson             = isset($data['contactPerson'])      ? $data['contactPerson']  : null;
        $this->contactEmail              = isset($data['contactEmail'])       ? $data['contactEmail']   : null;
        $this->contactNumber             = isset($data['contactNumber'])      ? $data['contactNumber']  : null;
        $this->owner                     = isset($data['owner'])              ? $data['owner']          : null;
        $this->teams                     = isset($data['teams'])              ? $data['teams']          : null;
        $this->lastUpdateDate            = isset($data['lastUpdateDate'])     ? $data['lastUpdateDate'] : null;
        $this->deliverables              = isset($data['deliverables'])       ? $data['deliverables']   : null;
        $this->overview                  = isset($data['overview'])           ? $data['overview']       : null;
        $this->scope                     = isset($data['scope'])              ? $data['scope']          : null;
        $this->outOfScope                = isset($data['outOfScope'])         ? $data['outOfScope']     : null;
        $this->metrics                   = isset($data['metrics'])            ? $data['metrics']        : null;
        $this->itResources               = isset($data['itResources'])        ? $data['itResources']    : null;
        $this->marginRate                = isset($data['marginRate'])         ? $data['marginRate']     : null;
        $this->costPerHour               = isset($data['costPerHour'])        ? $data['costPerHour']    : null;
        $this->costPerStep               = isset($data['costPerStep'])        ? $data['costPerStep']    : null;
        $this->dailyRate                 = isset($data['dailyRate'])          ? $data['dailyRate']      : null;
        $this->costInPesos               = isset($data['costInPesos'])        ? $data['costInPesos']    : null;
        $this->totalInPhp                = isset($data['totalInPhp'])         ? $data['totalInPhp']     : null;
        $this->totalInDollars            = isset($data['totalInDollars'])     ? $data['totalInDollars'] : null;
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
                            'name'       => 'processId',
                            'required'   => true,
                            'filters' => array(
                                            array('name'    => 'Int'),
                            ),
            )));
    
            $fieldsWithInt = array(
                            'parentId',
                            'userId',
                            'status',
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
    
	public function updateProcessComputations($objProcess, $arrProcessSteps)
	{
		$objProcess->costPerHour = 0;
		$objProcess->costPerStep = 0;
		$objProcess->dailyRate = 0;
		$objProcess->costInPesos = 0;
		$objProcess->totalInPhp = 0;
		$objProcess->totalInDollars = 0;
		
		foreach ($arrProcessSteps as $objProcessStep) {
			$objProcess->costPerHour += $objProcessStep->costPerHour;
			$objProcess->costPerStep += $objProcessStep->costPerStep;
			$objProcess->dailyRate += $objProcessStep->dailyRate;
			$objProcess->costInPesos += $objProcessStep->costInPesos;
			$objProcess->totalInPhp += $objProcessStep->totalInPhp;
			$objProcess->totalInDollars += $objProcessStep->totalInDollars;
		}

		return $objProcess;
	}
}