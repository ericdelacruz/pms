<?php
namespace Team\Controller;

use SAC\Mvc\Controller;
use Team\Model\Team;

class TeamController extends Controller
{
    
    public function indexAction()
    {
        $teams = $this->getEntity()->findAll();
        
        if (!$teams) {
            return $this->redirect()->toRoute('dashboard');
        }
        return compact('teams');
    }

    public function addAction()
    {
        $objTeamEntity = $this->getEntity();
        $objTeam = new Team();
        $objTeam->setEntity($objTeamEntity);
        
        $objRequest = $this->getRequest();
        
        $arrData = $objTeam->add($objRequest);
        
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
    	$teamId = (int) $this->params()->fromRoute('id', 0);
    	if (!$teamId) {
    		return $this->redirect()->toRoute('team', array(
    				'action' => 'add'
    		));
    	}
    	
    	$objTeamEntity = $this->getEntity();
    	$objTeam = new Team();
    	$objTeam->setEntity($objTeamEntity);
    	
    	$objRequest = $this->getRequest();
    	
    	$arrData = $objTeam->edit($teamId, $objRequest);
    	
    	$bRedirect = $arrData['redirect'];

    	if ($bRedirect)
    	    return $this->redirect()->toRoute($bRedirect);

	    $form = $arrData['form'];
	    return compact('teamId', 'form');
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('team');
        }
        
        $objTeamEntity = $this->getEntity();
        $objTeam = new Team();
        $objTeam->setEntity($objTeamEntity);
         
        $objRequest = $this->getRequest();
        
        $arrData = $objTeam->delete($id, $objRequest);
        
        $bRedirect = $arrData['redirect'];
        
        if ($bRedirect)
            return $this->redirect()->toRoute($bRedirect);
        
        $team = $this->getEntity()->find($id);
        return compact('id', 'team');
    }
}