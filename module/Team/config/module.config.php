<?php
return array(
                'controllers' => array(
                                'invokables' => array(
                                                'Team\Controller\Team' => 'Team\Controller\TeamController',
                                ),
                ),

                'router' => array(
                                'routes' => array(
                                                'team' => array(
                                                                'type'    => 'segment',
                                                                'options' => array(
                                                                                'route'    => '/team[/:action][/:id]',
                                                                                'constraints' => array(
                                                                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                                                                'id'     => '[0-9]+',
                                                                                ),
                                                                                'defaults' => array(
                                                                                                'controller' => 'Team\Controller\Team',
                                                                                                'action'     => 'index',
                                                                                ),
                                                                ),
                                                ),
                                ),
                ),

                'view_manager' => array(
                                'template_path_stack' => array(
                                                'team' => __DIR__ . '/../view',
                                ),
                ),
                'doctrine' => array(
                                'driver' => array(
                                                'Team_entities' => array(
                                                                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                                                                'cache' => 'array',
                                                                'paths' => array(__DIR__ . '/../src/' . 'Team/Entity')
                                                ),
                                                'orm_default' => array(
                                                                'drivers' => array(
                                                                                'Team\Entity' => 'Team_entities'
                                                                ),
                                                ),
                                ),
                ),
);