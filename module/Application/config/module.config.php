<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
	'router' => array(
		'routes' => array(
			'home' => array(
				'type' => 'segment',
				'options' => array(
					'route'		=> '/',
					'defaults' 	=> array(
						'controller'	=> 'Application\Controller\Index',
						'action'		=> 'index',
					),
				),
			),
			'add' => array(
				'type' => 'segment',
				'options' => array(
					'route'		=> '/add[/:process]',
					'defaults' 	=> array(
						'controller'	=> 'Application\Controller\Index',
						'action'		=> 'Add',
					),
				),
			),
			'login' => array(
				'type' => 'segment',
				'options' => array(
					'route'		=> '/login[/:process]',
					'defaults' 	=> array(
						'controller'	=> 'Application\Controller\Login',
						'action'		=> 'Index',
					),
				),
			),
			'logout' => array(
				'type' => 'segment',
				'options' => array(
					'route'		=> '/logout',
					'defaults' 	=> array(
						'controller'	=> 'Application\Controller\Login',
						'action'		=> 'Logout',
					),
				),
			),
			'chat' => array(
				'type' => 'segment',
				'options' => array(
					'route'		=> '/chat',
					'defaults' 	=> array(
						'controller'	=> 'Application\Controller\Chat',
						'action'		=> 'Index',
					),
				),
			),
			'post' => array(
				'type' => 'segment',
				'options' => array(
					'route'		=> '/chat/post[/:uid]',
					'defaults' 	=> array(
						'controller'	=> 'Application\Controller\Chat',
						'action'		=> 'Post',
					),
					'constraints' => array(
						'uid'		=> '[0-9]+',
					),
				),
			),
			'refresh' => array(
				'type' => 'segment',
				'options' => array(
					'route'		=> '/chat/refresh',
					'defaults' 	=> array(
						'controller'	=> 'Application\Controller\Chat',
						'action'		=> 'Chat',
					),
				),
			),
		),
	),
	'service_manager' => array(
		'abstract_factories' => array(
			'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
			'Zend\Log\LoggerAbstractServiceFactory',
		),
		'aliases' => array(
			'translator' => 'MvcTranslator',
		),
	),
	'translator' => array(
		'locale' => 'en_US',
		'translation_file_patterns' => array(
			array(
				'type'     => 'gettext',
				'base_dir' => __DIR__ . '/../language',
				'pattern'  => '%s.mo',
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Application\Controller\Index'	=>	'Application\Controller\IndexController',
			'Application\Controller\Login'	=>	'Application\Controller\LoginController',
			'Application\Controller\Chat'	=>	'Application\Controller\ChatController'
		),
	),
	'view_manager' => array(
		'display_not_found_reason' => true,
		'display_exceptions'       => true,
		'doctype'                  => 'HTML5',
		'not_found_template'       => 'error/404',
		'exception_template'       => 'error/index',
		'template_map' => array(
			'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
			'login/layout'            => __DIR__ . '/../view/application/login/layout.phtml',
			'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
			'error/404'               => __DIR__ . '/../view/error/404.phtml',
			'error/index'             => __DIR__ . '/../view/error/index.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
	// Placeholder for console routes
	'console' => array(
		'router' => array(
			'routes' => array(
			),
		),
	),
);
