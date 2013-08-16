<?php
return array(
    'router' => array(
        'routes' => array(
            'correio-cep' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/correios/restCep',
                    'defaults' => array(                       
                        'controller' => 'DrkCorreios\Controller\CurlRest',                        
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
    		'invokables' => array(
    				'DrkCorreios\Controller\CurlRest' => 'DrkCorreios\Controller\CurlRestController'
    		),
    ),
    'view_manager' => array(
    	'strategies' => array(
            'ViewJsonStrategy'
        )
    ),
);