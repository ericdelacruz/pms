<?php
namespace Resource\Model;

use SAC\Model\Common;

use Doctrine\ORM\Mapping\Entity;

use Resource\Form\ResourceForm;
use Resource\Entity\ResourceEntity;

class Resource extends Common
{
    public function add($objRequest) {
        $arrData = array('redirect' => false, 'form' => '');

        //get teams
        $arrTeams = $this->_arrDAO['Team']->findAll();

        //get salaries
        $arrSalaries = $this->_arrDAO['Salary']->findAll();

        $objResourceForm = new ResourceForm($arrTeams, $arrSalaries);
        $objResourceForm->get('submit')->setValue('Add');

        if ($objRequest->isPost()) {
            $objResourceForm->setData($objRequest->getPost());

            if ($objResourceForm->isValid()) {
                $objResourceEntity = new ResourceEntity();

                $objResourceEntity->exchangeArray($objResourceForm->getData());

                $this->_arrDAO['Resource']->save($objResourceEntity);
                 
                // Redirect to list of resources
                $arrData['redirect'] = 'resource';
            }

        }

        $arrData['form'] = $objResourceForm;

        return $arrData;
    }

    public function edit($intId, $objRequest) {
        $arrData = array('redirect' => false, 'form' => '');

        if (!$this->_arrDAO['Resource']) {
            $arrData['redirect'] = 'dashboard';
        } else {
            $objResourceValue = $this->_arrDAO['Resource']->find($intId);

            //get teams
            $arrTeams = $this->_arrDAO['Team']->findAll();

            //get salaries
            $arrSalaries = $this->_arrDAO['Salary']->findAll();

            $objResourceForm = new ResourceForm($arrTeams, $arrSalaries);

            $objResourceForm->bind($objResourceValue);

            if ($objRequest->isPost()) {
                $objResourceForm->setInputFilter($objResourceValue->getInputFilter())->setData($objRequest->getPost());

                if ($objResourceForm->isValid()) {
                    $this->_arrDAO['Resource']->flush();
                    $arrData['redirect'] = 'resource';
                }
            }
            $arrData['form'] = $objResourceForm;
        }

        return $arrData;
    }

    public function delete($id, $objRequest) {
        $arrData = array('redirect' => false, 'form' => '');

        if ($objRequest->isPost()) {
            $strDelete = $objRequest->getPost('del', 'No');
             
            if ($strDelete == 'Yes') {
                $objResourceValue = $this->_objDAO->find($id);

                $this->_objDAO->delete($objResourceValue);
            }
             
            $arrData['redirect'] = 'resource';
        }

        return $arrData;
    }
}