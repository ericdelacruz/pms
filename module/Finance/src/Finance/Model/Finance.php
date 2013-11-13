<?php
namespace Finance\Model;

use SAC\Model\Common;

use Finance\Form\FinanceForm;
use Finance\Entity\FinanceEntity;
use Finance\Model\FinanceDAO;

class Finance extends Common
{
    private $_objFinanceEntity;
    
    public function edit($intId, $objRequest) {
        $arrData = array('redirect' => false, 'form' => '');

        if (!$this->_objDAO) {
            $arrData['redirect'] = 'dashboard';
        } else {
            $objFinanceValue = $this->_objDAO->find($intId);

            $objForm = new FinanceForm();

            $objForm->bind($objFinanceValue);

            if ($objRequest->isPost()) {
                $objForm->setInputFilter($objFinanceValue->getInputFilter())->setData($objRequest->getPost());

                if ($objForm->isValid()) {
                    $this->_objDAO->flush();
                    $arrData['redirect'] = 'finance';
                }
            }
            $arrData['form'] = $objForm;
        }

        return $arrData;
    }
}