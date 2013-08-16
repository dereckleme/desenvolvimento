<?php
namespace Pagamento;

use Pagamento\Service\Estoque as serviceEstoque;


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
    
    public function getServiceConfig(){
    	return array(
    	    'factories' => array(
    	        'Pagamento\Service\Estoque' => function($service){
    	    	    $estoque = new serviceEstoque($service->get('Doctrine\ORM\EntityManager'));
    	    	    return $estoque;
    	        },
    	        /*'Pagamento\Repository\Estoque' => function($service){
    	            $em = $service->get("Doctrine\ORM\EntityManager");
    	            $repositor = $em->getRepository("Pagamento\Entity\PagamentoControleestoque");
    	            return $repositor;
    	        }*/
    	        'Pagamento\Service\Recibo' => function($service){
    	        	$estoque = new Recibo($service->get('Doctrine\ORM\EntityManager'));
    	        	return $estoque;
    	        },
    	        
    	    )
    	);
    }
    
}
