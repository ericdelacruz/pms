<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Form\LoginForm;
use SAC\Mvc\Controller;

use User\Model\User;

class LoginController extends AbstractActionController
{
    protected $form;
    protected $storage;
    protected $authservice;
    
    public function getAuthService()
    {
        if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()->get('AuthService');
        }
        
        return $this->authservice;
    }
    
    public function getSessionStorage()
    {
        if (! $this->storage) {
            $this->storage = $this->getServiceLocator()->get('User\Model\AuthStorage');
        }
        return $this->storage;
    }
    
    public function indexAction()
    {
        //if already login, redirect to home page
        if ($this->getAuthService()->hasIdentity()){
            return $this->redirect()->toRoute('dashboard');
        }
                
        //$form = $this->getForm();
        $form = new LoginForm();

        return array(
            'form' => $form,
            'messages' => $this->flashmessenger()->getMessages()
        );
    }
    
    public function authenticateAction()
    {
    	$form = new LoginForm();
        $redirect = 'login';
        
        $request = $this->getRequest();
        if ($request->isPost()){
            $form->setData($request->getPost());
            if ($form->isValid()){
                //check authentication...
                $authService = $this->getAuthService();
            	$authAdapter = $authService->getAdapter();
                $authAdapter->setIdentity($request->getPost('username'))->setCredential($request->getPost('password'));

                $result = $authService->authenticate();

                foreach($result->getMessages() as $message)
                {
                    //save message temporary into flashmessenger
                    $this->flashmessenger()->addMessage($message);
                }

                if ($result->isValid()) {
                    $redirect = 'dashboard';
                    //check if it has rememberMe :
                    if ($request->getPost('rememberme') == 1 ) {
                        $this->getSessionStorage()->setRememberMe(1);
                        //set storage again 
                        $authService->setStorage($this->getSessionStorage());
                    }
                    //$authService->getStorage()->write($request->getPost('username'));
                    $authService->getStorage()->write($authAdapter->getResultRowObject(null, 'password'));
                }
            }
        }
        
        return $this->redirect()->toRoute($redirect);
    }
    
    public function logoutAction()
    {
        $this->getSessionStorage()->forgetMe();
        $this->getAuthService()->clearIdentity();
        
        $this->flashmessenger()->addMessage("You've been logged out");
        return $this->redirect()->toRoute('login');
    }
}