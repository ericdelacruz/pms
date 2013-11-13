<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Process\Controller\Process' => 'Process\Controller\ProcessController',
        ),
		'factories' => array(
			'Process' => 'Process\Controller\ProcessController',
		),
    ),

    // The following section is new and should be added to your file
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
			'stepresources' => array(
				'type'    => 'Literal',
				'options' => array(
						'route'    => '/process/resources',
						'defaults' => array(
								'__NAMESPACE__' => 'Process\Controller',
								'controller'    => 'Process',
								'action'        => 'stepresources',
						),
				),
			),
        ),
    ),

    'view_manager' => array(
		'template_map'             => array(
			'process/ajax/view' => __DIR__ . '/../view/process/ajax/view.phtml',
		),
        'template_path_stack' => array(
            'process' => __DIR__ . '/../view',
        ),
    ),
);