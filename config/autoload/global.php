<?php
return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'dbname'   => 'pms',
                    'driverOptions' => array('1002' => 'SET NAMES utf8'),
                ),
            ),
        ),
    ),

    // TableGateway configuration
    // To be removed once migration to Doctrine is complete
    'db' => array(
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=pms;host=localhost',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
                    => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),

);