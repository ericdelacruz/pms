<?php
namespace Process;

use Process\Model\Process;
use Process\Model\ProcessTable;
use Process\Model\Step;
use Process\Model\StepTable;
use Process\Model\StepResource;
use Process\Model\StepResourceTable;
use Process\Model\Media;
use Process\Model\MediaTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
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
                'Process\Model\ProcessTable' =>  function($sm) {
                    $tableGateway = $sm->get('ProcessTableGateway');
                    $table = new ProcessTable($tableGateway);
                    return $table;
                },
                'ProcessTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Process());
                    return new TableGateway('processes', $dbAdapter, null, $resultSetPrototype);
                },
                'Process\Model\StepTable' =>  function($sm) {
                	$tableGateway = $sm->get('StepTableGateway');
                	$table = new StepTable($tableGateway);
                	return $table;
                },
                'StepTableGateway' => function ($sm) {
                	$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                	$resultSetPrototype = new ResultSet();
                	$resultSetPrototype->setArrayObjectPrototype(new Step());
                	return new TableGateway('steps', $dbAdapter, null, $resultSetPrototype);
                },
                'Process\Model\MediaTable' =>  function($sm) {
                	$tableGateway = $sm->get('MediaTableGateway');
                	$table = new MediaTable($tableGateway);
                	return $table;
                },
                'MediaTableGateway' => function ($sm) {
                	$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                	$resultSetPrototype = new ResultSet();
                	$resultSetPrototype->setArrayObjectPrototype(new Media());
                	return new TableGateway('media', $dbAdapter, null, $resultSetPrototype);
                },
                'Process\Model\StepResourceTable' =>  function($sm) {
                	$tableGateway = $sm->get('StepResourceTableGateway');
                	$table = new StepResourceTable($tableGateway);
                	return $table;
                },
                'StepResourceTableGateway' => function ($sm) {
                	$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                	$resultSetPrototype = new ResultSet();
                	$resultSetPrototype->setArrayObjectPrototype(new StepResource());
                	return new TableGateway('stepResources', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}