<?php
namespace Finance\Controller;

use SAC\Mvc\Controller;
use Finance\Model\Finance;

class FinanceController extends Controller
{

    public function viewAction()
    {
        $finance = $this->getEntity()->find(1);

        if (!$finance) {
            return $this->redirect()->toRoute('dashboard');
        }
        return compact('finance');
    }

    public function editAction()
    {
        $id = 1;

        $objFinanceEntity = $this->getEntity();
        $objFinance = new Finance();
        $objFinance->setDAO($objFinanceEntity);

        $objRequest = $this->getRequest();

        $arrData = $objFinance->edit($id, $objRequest);

        $bRedirect = $arrData['redirect'];

        if ($bRedirect)
            return $this->redirect()->toRoute($bRedirect);
        else {
            $form = $arrData['form'];
            return compact('id', 'form');
        }
    }
}
