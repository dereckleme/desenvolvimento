<?php
return array(
    'router' => array(
    		'routes' => array(
    		    'admin-financeiro' => array(
    		    		'type'    => 'Literal',
    		    		'options' => array(
    		    				'route'    => '/administrador/financeiro',
    		    				'defaults' => array(
    		    						'__NAMESPACE__' => 'Pagamento\Controller',
    		    						'controller'    => 'Financeiro',
    		    						'action'        => 'index',
    		    				),
    		    		),
    		    		'may_terminate' => true,
    		    		'child_routes' => array(
    		    				'admin-financeiro-action' => array(
    		    						'type'    => 'Segment',
    		    						'options' => array(
    		    								'route'    => '[/:action]',
    		    								'constraints' => array(
    		    										'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
    		    								),
    		    								'defaults' => array(
    		    								),
    		    						),
    		    				),
    		    		),
    		    ),
    		    )
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
    'controllers' => array(
    		'invokables' => array(
    				'Pagamento\Controller\Financeiro' => 'Pagamento\Controller\FinanceiroController',
    		),
    ),
    'view_manager' => array(
    		'display_not_found_reason' => true,
    		'display_exceptions'       => true,
    		'doctype'                  => 'HTML5',
    		'not_found_template'       => 'error/404',
    		'exception_template'       => 'error/index',
    		'template_map' => array(
    				'Layout/admin_logado_adm'           => __DIR__ . '/../view/layout/layout.phtml',
    				'Pagamento/index/index' => __DIR__ . '/../view/pagamento/index/index.phtml',
    				'error/404'               => __DIR__ . '/../view/error/404.phtml',
    				'error/index'             => __DIR__ . '/../view/error/index.phtml',
    		),
    		'template_path_stack' => array(
    				__DIR__ . '/../view',
    		),
    ),
);