<?php
namespace User;

use User\Model\User;
use User\Model\UserTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'User\Model\UserTable' =>  function($sm) {
                    $tableGateway = $sm->get('UserTableGateway');
                    $table = new UserTable($tableGateway);
                    return $table;
                },
                'UserTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new User());
                    return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                },
                'User\Model\AuthStorage' => function($sm){
                	return new \User\Model\AuthStorage('zf2tutorial');
                },
                'AuthService' => function($sm) {
                	$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                	$dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter, 'users','username','password', 'MD5(?)');
                	$authService = new AuthenticationService();
                	$authService->setAdapter($dbTableAuthAdapter);
                	$authService->setStorage($sm->get('User\Model\AuthStorage'));
                	 
                	return $authService;
                },
                'User\Model\User' => function($sm) { //dbAdapter injection for form
                	$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                	$user = new User();
                	$user->setDbAdapter($dbAdapter);
                	return $user;
                },
            ),
        );
    }
}