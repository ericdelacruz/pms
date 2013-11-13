<?php
namespace Team\Model;

use Doctrine\ORM\Mapping\Entity;

use Team\Form\TeamForm;
use Team\Entity\TeamEntity;
use Team\Model\TeamDAO;

class Team
{
    private $_objTeamEntity;

    public function add($objRequest) {
        $arrData = array('redirect' => false, 'form' => '');

        $objTeamForm = new TeamForm();
        $objTeamForm->get('submit')->setValue('Add');

        if ($objRequest->isPost()) {
            $objTeamForm->setData($objRequest->getPost());

            if ($objTeamForm->isValid()) {
                $objTeamEntity = new TeamEntity();

                $objTeamEntity->exchangeArray($objTeamForm->getData());

                $this->_objTeamEntity->save($objTeamEntity);
                 
                // Redirect to list of teams
                $arrData['redirect'] = 'team';
            }

        }

        $arrData['form'] = $objTeamForm;

        return $arrData;
    }

    public function edit($intId, $objRequest) {
        $arrData = array('redirect' => false, 'form' => '');

        if (!$this->_objTeamEntity) {
            $arrData['redirect'] = 'dashboard';
        } else {
            $objTeamValue = $this->_objTeamEntity->find($intId);

            $objForm = new TeamForm();

            $objForm->bind($objTeamValue);

            if ($objRequest->isPost()) {
                $objForm->setInputFilter($objTeamValue->getInputFilter())->setData($objRequest->getPost());

                if ($objForm->isValid()) {
                    $this->_objTeamEntity->flush();
                    $arrData['redirect'] = 'team';
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
                $objTeamValue = $this->_objTeamEntity->find($id);

                $this->_objTeamEntity->delete($objTeamValue);
            }
             
            $arrData['redirect'] = 'team';
        }

        return $arrData;
    }

    public function setEntity($objTeamEntity) {
        $this->_objTeamEntity = $objTeamEntity;
    }
}