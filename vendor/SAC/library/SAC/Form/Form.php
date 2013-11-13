<?php

namespace SAC\Form;

use Zend\Form\Form as BaseForm;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class Form extends BaseForm implements ServiceManagerAwareInterface
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * Init the form
     */
    public function init()
    {
    }

    /**
     * @param ServiceManager $serviceManager
     * @return Form
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;

        // Call the init function of the form once the service manager is set
        $this->init();

        return $this;
    }
    
	/*basic text input*/
    protected function _addTextInput($strName, $strLabel, $strValue = '') {
    	return array(
    			'name' => $strName,
    			'attributes' => array(
    					'type'  => 'text',
    					'value' => $strValue
    			),
    			'options' => array(
    					'label' => $strLabel,
    			),
    	);
    }
    
    protected function _addTextAreaInput($strName, $strLabel, $intId = '') {
    	return array(
    			'name' => $strName,
    			'attributes' => array(
    					'type'  => 'textarea',
    					'id' => $intId,
    			),
    			'options' => array(
    					'label' => $strLabel,
    			),
    	);
    }
}