<?php
namespace DrkCorreios;

use DrkCorreios\Service\DrkCorreios as serviceCurl;
use DrkCorreios\Service\Frete as serviceFrete;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig() {    
    	return array(
    			'factories' => array(
    			    'DrkCorreios\Service\DrkCorreios' => function($service){
    			    	$curl = new serviceCurl();
    			    	return $curl;
    			    },
    			    'DrkCorreios\Service\Frete' => function($service){
    			    	$curl = new serviceFrete($service);
    			    	return $curl;
    			    },
    			),
    	);
    }
    
}
