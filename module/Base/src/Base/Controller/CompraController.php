<?php

/**
 * dereck
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Base\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator,
    Zend\Paginator\Adapter\ArrayAdapter;


use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;

class CompraController extends AbstractActionController
{    
    public function indexAction()
    {
        $service = $this->getServiceLocator()->get('CarrinhoCompras\Model\Carrinho');
    	return new viewModel(array("carrinhoLista" => array(
    				"listaAtual" =>  $service->lista(),
    				"valorTotal" => $service->calculoTotal()
    		)));
    }
    public function finalizaAction()
    {
        $service = $this->getServiceLocator()->get('CarrinhoCompras\Model\Carrinho');
        $auth = new AuthenticationService;
        $auth->setStorage(new SessionStorage("Usuario"));
        
    	return new viewModel(array("carrinhoLista" => array(
    				"listaAtual" =>  $service->lista(),
    				"valorTotal" => $service->calculoTotal(),
    	            "auth" => $auth
    		)));
    }
}
