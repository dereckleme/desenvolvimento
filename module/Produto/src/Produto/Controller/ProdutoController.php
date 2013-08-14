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
        $repositor = $this->getServiceLocator()->get("Produto\Repository\Produtos");
        $repositorCat = $this->getServiceLocator()->get("Produto\Repository\Categorias");        
        
        $categoriaValues = array();
        $categoriaValues[""] = "--SELECIONE--";
        foreach($repositorCat->findAll() as $categoria)
        {
        	$categoriaValues[$categoria->getIdcategorias()] = $categoria->getNome();
        }
        
    	$form = new FrmProduto;    	    
    	$select = $form->get('inputCategoria');
    	$select->setValueOptions($categoriaValues);
    	
        return new ViewModel(array('form'=>$form, "produtos"=>$repositor->findAll(), "categorias"=>$repositorCat->findAll()));
    }
    
    public function subCategoriaByCategoriaAction(){        
        $repositor = $this->getServiceLocator()->get("Produto\Repository\Categorias");
        
        $request = $this->getRequest();
        if($request->isPost())
        {
            $data = $this->getRequest()->getPost('valor');
            
            $valueOptions = "<option value=''>--SELECIONE--</option>\n";
            foreach($repositor->findByIdcategorias($data) as $categoria)
            {
            	foreach($categoria->getSubcategorias() as $subcategoria)
            	{
            		$valueOptions .= "<option value='{$subcategoria->getIdsubcategoria()}'>{$subcategoria->getNome()}</option>\n";
            	}
            }
        }
        else
        {
            $valueOptions = "Erro interno.";
        }
        
        $viewModel = new ViewModel(array('mensagem' => $valueOptions)); // chama uma view
        $viewModel->setTerminal(true); // desativa layout.phtml
        return $viewModel;
    }
    
    public function adicionarAction(){        
        $repositorCat =  $this->getServiceLocator()->get("Produto\Repository\Categorias");        
        #$repositor = $em->getRepository("Produto\Entity\PagamentoControleestoque");
        
        $categoriaValues = array();
        $subCategoriaValues = array();
        $categoriaValues[""] = "--SELECIONE--";
        $subCategoriaValues[""] = "--SELECIONE--";
        foreach($repositorCat->findAll() as $categoria)
        {
            foreach($categoria->getSubcategorias() as $subcategoria)
            {
                $subCategoriaValues[$subcategoria->getIdsubcategoria()] = $subcategoria->getNome();
            }
        	$categoriaValues[$categoria->getIdcategorias()] = $categoria->getNome();
        }
        
        
        $form = new FrmProduto;
    	
        $comboCategoria = $form->get('inputCategoria');
        $comboCategoria->setValueOptions($categoriaValues);
        
        $comboSubCategoria = $form->get('inputSubCategoria');
        $comboSubCategoria->setValueOptions($subCategoriaValues);
        
        
    	$request = $this->getRequest();    	
    	if($request->isPost())
    	{
    	    $form->setData($request->getPost());
    	    
    	    if($form->isValid())
    	    {
    	    	$data = $this->getRequest()->getPost()->toArray();
    	    	
    	    	$service = $this->getServiceLocator()->get("Produto\Service\Produto");
    	    	$produto = $service->insert($data);
    	    	    /*	    	
    	    	$serviceEstoque = $this->getServiceLocator()->get("Pagamento\Service\Estoque");
    	    	$teste = $serviceEstoque->insert(array('produtoproduto'=>$produto->getIdproduto(), 'quantidade'=>'60'));
    	    	*/
    	    	
    	    	die();
    	    	
    	    	
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
        $repositor = $this->getServiceLocator()->get("Produto\Repository\Produtos");
        
        
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