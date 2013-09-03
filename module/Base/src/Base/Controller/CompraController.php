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
        $entity = null;
        $estados = null;
        $service = $this->getServiceLocator()->get('CarrinhoCompras\Model\Carrinho');
        $auth = new AuthenticationService;
        $auth->setStorage(new SessionStorage("Usuario"));
        if($auth->hasIdentity())
        {
            $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
            $entity = $em->getRepository("Usuario\Entity\UsuarioCadastro")->findOneByusuariosusuarios($auth->getIdentity()->getIdusuario());
            $estados = $em->getRepository("Usuario\Entity\MapeamentoEstado")->findAll();
        }
    	return new viewModel(array("carrinhoLista" => array(
    				"listaAtual" =>  $service->lista(),
    				"valorTotal" => $service->calculoTotal(),
    	            
    		),"auth" => $auth,"cadastro" => $entity, "estados" => $estados));
    }
}
