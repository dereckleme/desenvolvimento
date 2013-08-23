<?php
namespace Base;
use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;

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
    public function onBootstrap($e)
    {
    	$e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e) {
    		/*
    		 * Definições de sessoes
    		*/
    		$auth = new AuthenticationService;
    		$auth->setStorage(new SessionStorage("Usuario"));
    		$controller      = $e->getTarget();
    		$controllerClass = get_class($controller);
    		$moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
    		$config          = $e->getApplication()->getServiceManager()->get('config');
    		/*
    		 * Definição de Layout de todos modulos
    		*/
    		if($auth->hasIdentity())
    		{
    			 
    			if($auth->getIdentity()->getNivelUsuario() != 1)
    			{
    
    				if (isset($config['module_layouts'][$moduleNamespace])) {
    					$controller->layout($config['module_layouts'][$moduleNamespace]."_logado");
    					$controller->layout()->infoUser = $auth->getIdentity();
    				}
    			}
    			else
    			{
    				if (isset($config['module_layouts'][$moduleNamespace])) {
    					$controller->layout($config['module_layouts'][$moduleNamespace]."_logado_adm");
    					$controller->layout()->infoUser = $auth->getIdentity();
    				}
    			}
    		}
    		else
    		{
    
    			if (isset($config['module_layouts'][$moduleNamespace])) {
    				$controller->layout($config['module_layouts'][$moduleNamespace]);
    			}
    		}
    		/*
    		 * Permissão de usuário
    		*/
    		$matchedRoute = $controller->getEvent()->getRouteMatch()->getMatchedRouteName();
    		//////////////////////////
    		/*
    		 * Definições para bloqueio total de usuários no admin
    		*/
    		$adminRoute = explode("-",$matchedRoute);
    		if(!$auth->hasIdentity() and ($adminRoute[0] == "admin" || $adminRoute[0] == "Painel"))
    		{
    			return $controller->redirect()->toRoute("home");
    		}
    		else if($auth->hasIdentity())
    		{
    		    
    			 
    			if($auth->getIdentity()->getNivelUsuario() != 1)
    			{
    				if($adminRoute[0] == "admin")
    				{
    					return $controller->redirect()->toRoute("home");
    				}
    			}
    		}
    		/*
    		 * Carrinho de compras Session
    		 */
    		$eventoCarrinho = $e->getApplication()->getServiceManager()->get('CarrinhoCompras\Model\Carrinho');
    		$controller->layout()->carrinhoLista = array(
    		   "listaAtual" =>  $eventoCarrinho->lista(),
    		   "valorTotal" => $eventoCarrinho->calculoTotal()
    		);
    		/*
    		 * Listagem de categorias
    		 */
    		
    		$eventoCategoria = $e->getApplication()->getServiceManager()->get('Produto\Repository\Categorias');
    		$categorias = $eventoCategoria->findAll();
    		$controller->layout()->categorias = $categorias;
    		
    		/*
    		 * $matchedRoute
    		 */
    		$controller->layout()->matchedRoute = $matchedRoute;
    	}, 100);
    
    }
}
