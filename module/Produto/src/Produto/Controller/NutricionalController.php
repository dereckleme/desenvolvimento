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
use Produto\Form\Nutricional;


class NutricionalController extends AbstractActionController {
    
    protected $itens;
    protected $produtos;
    
    public function setItensValues($items){
        if(!$this->itens){            
            $this->itens[''] = '--SELECIONE--';
            foreach ($items as $item){
            	$this->itens[$item->getIdnutricionalNomes()] = $item->getNome();
            }	
        }        
        return $this->itens;
    }
    
    public function setProdutosValues(){
    	if(!$this->produtos){
    		$repository = $this->getServiceLocator()->get('Produto\Repository\Produtos');
    		$this->produtos[''] = '--SELECIONE--';
    		foreach ($repository->findAll() as $produto){
    			$this->produtos[$produto->getIdproduto()] = $produto->getTitulo();
    		}
    	}
    	return $this->produtos;
    }
    
    public function indexAction() {
        $repository = $this->getServiceLocator()->get('Produto\Repository\Nutricional');
        $data['itens'] = $repository->findAll();
        
        $repository2 = $this->getServiceLocator()->get('Produto\Repository\NutricionalTabela');        
        $data['tableNutricional'] = $repository2->findAll();
        
        $formulario = new Nutricional();
        $formulario->get('idnutricionalNomes')->setValueOptions($this->setItensValues($data['itens']));
        $formulario->get('idproduto')->setValueOptions($this->setProdutosValues());
        $data['form'] = $formulario;
        
        return new ViewModel($data);
    }

    public function adicionarItemAction()
    {        
        $request = $this->getRequest();
        if($request->isPost())
        {
        	$data = $request->getPost()->toArray();
        	if(!empty($data['saltda']))
        	{
        		$service = $this->getServiceLocator()->get('Produto\Service\Nutricional');
        		$service->insert(array("nome"=>$data['saltda']));
        		$viewModel = new ViewModel();
        	}
        	else 
        	{
        	    $viewModel = new ViewModel(array("mensagem" => ":( Campo nome está em branco."));
        	}
        }
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
    public function criarTabelaNutricionalAction()
    {
        $request = $this->getRequest();
        if($request->isPost())
        {
            $data = $request->getPost()->toArray();
            
            $service = $this->getServiceLocator()->get('Produto\Service\NutricionalTabela');        
            $service->insert($data);
            $viewModel = new ViewModel();
        }
        
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
    
}