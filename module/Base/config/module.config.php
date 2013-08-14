<?php
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Base\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'admin-administrador' => array(
            		'type' => 'Zend\Mvc\Router\Http\Literal',
            		'options' => array(
            				'route'    => '/administrador',
            				'defaults' => array(
            						'controller' => 'Base\Controller\Index',
            						'action'     => 'index',
            				),
            		),
            ),
        ),
    ),
    'controllers' => array(
    		'invokables' => array(
    				'Base\Controller\Index' => 'Base\Controller\IndexController'
    		),
    ),
    'view_manager' => array(
    		'display_not_found_reason' => true,
    		'display_exceptions'       => true,
    		'doctype'                  => 'HTML5',
    		'not_found_template'       => 'error/404',
    		'exception_template'       => 'error/index',
    		'template_map' => array(
    				'layout/layout'           => __DIR__ . '/../view/layout/empty.phtml',
    				'layout/site'           => __DIR__ . '/../view/layout/index.phtml',
    		        'layout/site_logado'           => __DIR__ . '/../view/layout/index_logado.phtml',
    		        'layout/site_logado_adm'           => __DIR__ . '/../view/layout/index_logado_adm.phtml',
    		        'layout/carrinho'                   => __DIR__ . '/../view/layout/layoutCarrinho.phtml',
    				'base/index/index' => __DIR__ . '/../view/base/index/index.phtml',
    				'error/404'               => __DIR__ . '/../view/error/404.phtml',
    				'error/index'             => __DIR__ . '/../view/error/index.phtml',
    		),
    		'template_path_stack' => array(
    				__DIR__ . '/../view',
    		),
    ),
);