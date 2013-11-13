<?php
namespace Resource\Controller;

use SAC\Mvc\Controller;
use Resource\Model\Resource;

class ResourceController extends Controller
{

    public function indexAction()
    {
        $resources = $this->getEntity()->findAll();

        if (!$resources) {
            return $this->redirect()->toRoute('dashboard');
        }
        return compact('resources');
    }

    public function addAction() {
        $arrModules = array('Team\Model\TeamDAO', 'Salary\Model\SalaryDAO', 'Resource\Model\ResourceDAO');

        $arrDAO = $this->_setMultipleDAO($arrModules);

        $objResource = new Resource();
        $objResource->setMultipleDAO($arrDAO);

        $objRequest = $this->getRequest();

        $arrData = $objResource->add($objRequest);

        $bRedirect = $arrData['redirect'];

        if ($bRedirect)
            return $this->redirect()->toRoute($bRedirect);
        else {
            $form = $arrData['form'];
            return compact('form');
        }
    }

    public function editAction()
    {
        $resourceId = (int) $this->params()->fromRoute('id', 0);
        if (!$resourceId) {
            return $this->redirect()->toRoute('resource', array(
                            'action' => 'add'
            ));
        }
         
        $arrModules = array('Team\Model\TeamDAO', 'Salary\Model\SalaryDAO', 'Resource\Model\ResourceDAO');

        $arrDAO = $this->_setMultipleDAO($arrModules);

        $objResource = new Resource();
        $objResource->setMultipleDAO($arrDAO);
         
        $objRequest = $this->getRequest();
         
        $arrData = $objResource->edit($resourceId, $objRequest);
         
        $bRedirect = $arrData['redirect'];

        if ($bRedirect)
            return $this->redirect()->toRoute($bRedirect);

        $form = $arrData['form'];
        return compact('resourceId', 'form');
    }

    public function deleteAction() {
        $resourceId = (int) $this->params()->fromRoute('id', 0);
        if (!$resourceId) {
            return $this->redirect()->toRoute('resource');
        }
        
        $objResourceEntity = $this->getEntity();
        $objResource = new Resource();
        $objResource->setDAO($objResourceEntity);
         
        $objRequest = $this->getRequest();
        
        $arrData = $objResource->delete($resourceId, $objRequest);
        
        $bRedirect = $arrData['redirect'];
        
        if ($bRedirect)
            return $this->redirect()->toRoute($bRedirect);
        
        $resource = $this->getEntity()->find($resourceId);
        return compact('resourceId', 'resource');
    }
}