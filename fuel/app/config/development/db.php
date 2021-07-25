<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.8.2
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

/**
 * -----------------------------------------------------------------------------
 *  Database settings for development environment
 * -----------------------------------------------------------------------------
 *
 *  These settings get merged with the global settings.
 *
 */

return array(
    'default' => array(
        'type'   => 'mysqli',
        'connection' => array(
            'hostname'   => 'localhost',
            'port'       => '3306',
            'database'   => 'test_db',
            'username'   => 'user01',
            'password'   => 'Password-123',
        ),
        'table_prefix' => '',
        'charset'      => 'utf8',
        'caching'      => false,
        'profiling'    => true,
    ),
/*
	'default' => array(
		'connection' => array(
			'dsn'      => 'mysql:host=localhost;dbname=fuel_dev',
			'username' => 'rootZZZZZZZZZ',
			'password' => 'root',
		),
	),
*/
);
