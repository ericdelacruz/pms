<?php
return array(
                'controllers' => array(
                                'invokables' => array(
                                                'Resource\Controller\Resource' => 'Resource\Controller\ResourceController',
                                ),
                ),

                'router' => array(
                                'routes' => array(
                                                'resource' => array(
                                                                'type'    => 'segment',
                                                                'options' => array(
                                                                                'route'    => '/resource[/:action][/:id]',
                                                                                'constraints' => array(
                                                                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                                                                'id'     => '[0-9]+',
                                                                                ),
                                                                                'defaults' => array(
                                                                                                'controller' => 'Resource\Controller\Resource',
                                                                                                'action'     => 'index',
                                                                                ),
                                                                ),
                                                ),
                                ),
                ),

                'view_manager' => array(
                                'template_path_stack' => array(
                                                'resource' => __DIR__ . '/../view',
                                ),
                ),

                'doctrine' => array(
                                'driver' => array(
                                                'Resource_entities' => array(
                                                                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                                                                'cache' => 'array',
                                                                'paths' => array(__DIR__ . '/../src/' . 'Resource/Entity')
                                                ),
                                                'orm_default' => array(
                                                                'drivers' => array(
                                                                                'Resource\Entity' => 'Resource_entities'
                                                                ),
                                                ),
                                ),
                ),
);