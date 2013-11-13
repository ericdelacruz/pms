<?php
namespace SAC\Mvc;

use Zend\Mvc\Controller\AbstractActionController;

use Zend\EventManager\EventManagerInterface;

abstract class Controller extends AbstractActionController
{
    /**
     * Inherited Entity Manager container
     * @var object
     */
    protected $entity;

    /**
     * Get Doctrine's entity manager for ORM calls
     * @param  string $namespace For overrides
     * @return object
     */
    protected function getEntity($namespace=null, $bOverride=false)
    {
        if(!$namespace) {
            $namespace = $this->getRootNamespace();
            $namespace = "{$namespace}\\Model\\{$namespace}DAO";
        }
        if (!$this->entity || $bOverride) {
            $sm = $this->getServiceLocator();
            $this->entity = $sm->get($namespace);
        }

        return $this->entity;
    }

    /**
     * Helper function for getEntity() to find the root namespace of a called class
     * @return string (e.g. "Finance\Controller\FinanceController" returns "Finance")
     */
    private function getRootNamespace()
    {
        $root = explode('\\', get_called_class());

        if(isset($root[0])) {
            return $root[0];
        } else {
            throw new \Exception('Root Namespace could not be found. Please specify an override on getEntity() instead.');
        }
    }

    public function setEventManager(EventManagerInterface $events)
    {
        parent::setEventManager($events);
        $controller = $this;
        $events->attach('dispatch', function ($e) use ($controller) {
            $request = $e->getRequest();
            $method  = $request->getMethod();

            if (!$this->zfcUserAuthentication()->hasIdentity()) { //redirect to login page
                return $this->redirect()->toRoute('zfcuser/login');
            }
        }, 100); // execute before executing action logic
    }

    protected function _setMultipleDAO($arrModules) {
        $arrDAO = array();
        foreach ($arrModules as $strModule) {
            $arrModulePath = explode('\\', $strModule);
            $arrDAO[$arrModulePath[0]] = $this->getEntity($strModule, true);
        }

        return $arrDAO;
    }

    // To be removed once migration to Doctrine is complete
    protected $strTable;
    public function getTable($strModule, $bNew = false, $strParentModule = '')
    {
        if (!$this->strTable || $bNew) {
            if (strlen($strParentModule) == 0 || '' == $strParentModule) {
                $strTableLink = $strModule.'\Model\\'.$strModule.'Table';
            } else {
                $strTableLink = $strParentModule.'\Model\\'.$strModule.'Table';
            }

            $sm = $this->getServiceLocator();

            $this->strTable = $sm->get($strTableLink);
        }
        return $this->strTable;
    }
}
