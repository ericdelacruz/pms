<?php
namespace Salary\Model;

use SAC\Model\Common;

use Doctrine\ORM\Mapping\Entity;

use Salary\Form\SalaryForm;
use Salary\Entity\SalaryEntity;
use Salary\Model\SalaryDAO;

class Salary extends Common
{
    public function add($objRequest) {
        $arrData = array('redirect' => false, 'form' => '');
        
        $objSalaryForm = new SalaryForm();
        $objSalaryForm->get('submit')->setValue('Add');
        
        if ($objRequest->isPost()) {
            $objSalaryForm->setData($objRequest->getPost());

            if ($objSalaryForm->isValid()) {
                $objSalaryEntity = new SalaryEntity();
                
                $objSalaryEntity->exchangeArray($objSalaryForm->getData());
                
                $this->_objDAO->save($objSalaryEntity);
                 
                // Redirect to list of salaries
               $arrData['redirect'] = 'salary';
            }

        }
        
        $arrData['form'] = $objSalaryForm;
        
        return $arrData;
    }
    
    public function edit($intId, $objRequest) {
        $arrData = array('redirect' => false, 'form' => '');

        if (!$this->_objDAO) {
            $arrData['redirect'] = 'dashboard';
        } else {
            $objSalaryValue = $this->_objDAO->find($intId);

            $objForm = new SalaryForm();

            $objForm->bind($objSalaryValue);

            if ($objRequest->isPost()) {
                $objForm->setInputFilter($objSalaryValue->getInputFilter())->setData($objRequest->getPost());

                if ($objForm->isValid()) {
                    $this->_objDAO->flush();
                    $arrData['redirect'] = 'salary';
                }
            }
            $arrData['form'] = $objForm;
        }

        return $arrData;
    }
    
    public function delete($id, $objRequest) {
        $arrData = array('redirect' => false, 'form' => '');
        
        if ($objRequest->isPost()) {
            $strDelete = $objRequest->getPost('del', 'No');
             
            if ($strDelete == 'Yes') {
                $objSalaryValue = $this->_objDAO->find($id);

                $this->_objDAO->delete($objSalaryValue);
            }
             
            $arrData['redirect'] = 'salary';
        }
        
        return $arrData;
    }
}