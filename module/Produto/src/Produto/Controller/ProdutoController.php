<?php

/**
 * dereck
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Produto\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Produto\Form\Produto as FrmProduto;

class ProdutoController extends AbstractActionController {

    public function indexAction() {    	
        $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
        $repositor = $em->getRepository("Produto\Entity\ProdutoProdutos");
        $repositorCat = $em->getRepository("Produto\Entity\ProdutoCategorias");        
        
    	$form = new FrmProduto;
        return new ViewModel(array('form'=>$form, "produtos"=>$repositor->findAll(), "categorias"=>$repositorCat->findAll()));
    }
    
    public function adicionarAction(){        
        $form = new FrmProduto;
    	
    	$request = $this->getRequest();    	
    	if($request->isPost())
    	{
    	    $form->setData($request->getPost());
    	    
    	    if($form->isValid())
    	    {
    	    	$data = $this->getRequest()->getPost()->toArray();
    	    	
    	    	$service = $this->getServiceLocator()->get("Produto\Service\Produto");
    	    	$service->insert($data);
    	    	
    	    	$return['success'] = "Cadastrado com sucesso";  	    	
    	    }
    	    else
    	    {    	        
    	        $errors = $form->getMessages();    	          	       
    	        $return['titulo'] = $errors['titulo']['isEmpty'];    	        
    	    }
    	    
    	}
    	else
    	{
    	    $return['error'] = "Ocorreu um erro interno";
    	}
    	    	
    	$viewModel = new ViewModel(array('mensagem' => json_encode($return))); // chama uma view
    	$viewModel->setTerminal(true); // desativa layout.phtml
    	return $viewModel;
    	
    }
    
    public function editarAction(){
        $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
        $repositor = $em->getRepository("Produto\Entity\ProdutoProdutos");
        
        
        //$entity = $repositor->find($this->params()->fromRoute('id',0));
    	return new ViewModel(array("produto"=>$repositor->find($this->params()->fromRoute('id',0)) ));
    }
    
    public function excluirAction(){
        $service = $this->getServiceLocator()->get("Produto\Service\Produto");
        if($service->delete($this->params()->fromRoute('id',0))){
            return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
        }                      
    }
    
}