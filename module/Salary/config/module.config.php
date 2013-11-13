<?php
return array(
		'controllers' => array(
				'invokables' => array(
						'Salary\Controller\Salary' => 'Salary\Controller\SalaryController',
				),
		),

		'router' => array(
				'routes' => array(
						'salary' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/salary[/:action][/:id]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'Salary\Controller\Salary',
												'action'     => 'index',
										),
								),
						),
				),
		),

		'view_manager' => array(
				'template_path_stack' => array(
						'salary' => __DIR__ . '/../view',
				),
		),
                
        'doctrine' => array(
                'driver' => array(
                        'Salary_entities' => array(
                                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                                'cache' => 'array',
                                'paths' => array(__DIR__ . '/../src/' . 'Salary/Entity')
                        ),
                        'orm_default' => array(
                                'drivers' => array(
                                                'Salary\Entity' => 'Salary_entities'
                                ),
                        ),
                ),
        ),
);