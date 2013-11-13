<?php
/**
 * @package Finance
 */
return array(
    'controllers' => array(
        'invokables' => array(
            'Finance\Controller\Finance' => 'Finance\Controller\FinanceController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'finance' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/finance[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Finance\Controller\Finance',
                        'action'     => 'view',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'user' => __DIR__ . '/../view',
        ),
    ),

    'doctrine' => array(
        'driver' => array(
            'Finance_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . 'Finance/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Finance\Entity' => 'Finance_entities'
                ),
            ),
        ),
    ),
);
