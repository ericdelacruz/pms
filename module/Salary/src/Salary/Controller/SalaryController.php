<?php
namespace Salary\Controller;

use SAC\Mvc\Controller;
use Salary\Model\Salary;


class SalaryController extends Controller
{	

    public function indexAction()
    {
        $salaries = $this->getEntity()->findAll();
        
        if (!$salaries) {
            return $this->redirect()->toRoute('dashboard');
        }
        return compact('salaries');
    }

    public function addAction()
    {
        $objSalaryEntity = $this->getEntity();
        $objSalary = new Salary();
        $objSalary->setDAO($objSalaryEntity);
        
        $objRequest = $this->getRequest();
        
        $arrData = $objSalary->add($objRequest);
        
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
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('salary', array(
    				'action' => 'add'
    		));
    	}

    	$objSalaryEntity = $this->getEntity();
    	$objSalary = new Salary();
    	$objSalary->setDAO($objSalaryEntity);
    	
    	$objRequest = $this->getRequest();
    	
    	$arrData = $objSalary->edit($id, $objRequest);
    	
    	$bRedirect = $arrData['redirect'];

    	if ($bRedirect)
    	    return $this->redirect()->toRoute($bRedirect);

	    $form = $arrData['form'];
	    return compact('id', 'form');
    }
    
    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('salary');
        }
        
        $objSalaryEntity = $this->getEntity();
        $objSalary = new Salary();
        $objSalary->setDAO($objSalaryEntity);
         
        $objRequest = $this->getRequest();
        
        $arrData = $objSalary->delete($id, $objRequest);
        
        $bRedirect = $arrData['redirect'];
        
        if ($bRedirect)
            return $this->redirect()->toRoute($bRedirect);
        
        $salary = $this->getEntity()->find($id);
        return compact('id', 'salary');
    }
}