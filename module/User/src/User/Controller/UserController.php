<?php
namespace User\Controller;

use Zend\View\Model\ViewModel;
use User\Form\UserForm;
use User\Form\UserEditForm;
use SAC\Mvc\Controller;

use User\Model\User;
use Resource\Model\Resource;

class UserController extends Controller
{
    protected $form;
    protected $storage;
    protected $authservice;
    protected $strModule = 'User';

    public function indexAction()
    {
        return new ViewModel(array(
            'users' => $this->getTable($this->strModule)->fetchAll(),
        ));
    }

    public function addAction()
    {
        //get resources
        $arrResources = $this->getTable('Resource', true)->fetchAll();

        //get teams
        $arrTeams = $this->getTable('Team', true)->fetchAll();

        //get Finance Settings
        $objFinanceSettings = $this->getTable('Finance', true)->getFinance();

        $form = new UserForm($arrTeams, $arrResources, $objFinanceSettings);
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $user = new User();
            $form->setInputFilter($user->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $user->exchangeArray($form->getData());

                $this->getTable($this->strModule, true)->saveUser($user);

                // Redirect to list of users
                return $this->redirect()->toRoute('user');
            }
        }
        return array(
            'form' => $form,
        );
    }


    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('user', array(
                    'action' => 'add'
            ));
        }
        $user = $this->getTable($this->strModule)->getUser($id);

        //get resources
        $arrResources = $this->getTable('Resource', true)->fetchAll();

        //get teams
        $arrTeams = $this->getTable('Team', true)->fetchAll();

        $form = new UserEditForm($arrTeams, $arrResources);
        $form->bind($user);
        $form->get('submit')->setAttribute('value', 'Save Changes');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $inputFilter = $user->getInputFilter();

            //remove passwords on the edit form
            $filter = $inputFilter->get('password');
            $filter->setRequired(false);
            $otherFilter = $inputFilter->get('passwordConfirmation');
            $otherFilter->setRequired(false);

            $form->setInputFilter($inputFilter);
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getTable($this->strModule, true)->saveUser($form->getData());

                // Redirect to list of users
                return $this->redirect()->toRoute('user');
            }
        }

        return array(
                'user_id' => $id,
                'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('user');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('user_id');
                $this->getTable($this->strModule)->deleteUser($id);
            }

            // Redirect to list of users
            return $this->redirect()->toRoute('user');
        }

        return array(
                'user_id'    => $id,
                'user' => $this->getTable($this->strModule)->getUser($id)
        );
    }

    /* AJAX */
    public function getUserByResourceAjaxAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        $arrUsers = $this->getTable($this->strModule, true)->fetchAllByField('resourceId', $id);
        //$arrData['users'] = $this->getTable('Salary', true)->getSalary(1);

        foreach ($arrUsers as $objUser) {
            $arrUser[] = $objUser;
        }

        $arrData['users'] = $arrUser;

        $objView = new ViewModel(array(
                'data'    => $arrData
        ));
        $objView->setTerminal(true);
        $objView->setTemplate('user/ajax/view.phtml');

        return $objView;
    }
}