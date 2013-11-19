<?php
/**
 * @package Process
 */
return array(
    'controllers' => array(
        'invokables' => array(
            'Process\Controller\Process' => 'Process\Controller\ProcessController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'process' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/process[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Process\Controller\Process',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'process' => __DIR__ . '/../view',
        ),
    ),

    'doctrine' => array(
        'driver' => array(
            'Process_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . 'Process/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Process\Entity' => 'Process_entities'
                ),
            ),
        ),
    ),
);
