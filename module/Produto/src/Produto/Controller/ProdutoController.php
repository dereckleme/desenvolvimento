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
use Zend\Validator\File\Size;
use Zend\File\Transfer\Adapter\Http;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
use Produto\Entity\ProdutoProdutos;

class ProdutoController extends AbstractActionController {

    protected $categoriaValue;
    protected $subCategoriaValue;
    
    public function getCategoryValuesOptions(){
    	if(!$this->categoriaValue){
    	    $repository = $this->getServiceLocator()->get("Produto\Repository\Categorias");
    	    
    	    $this->categoriaValue[""] = "--SELECIONE--";
    	    foreach ($repository->findAll() as $result){
    	    	$this->categoriaValue[$result->getIdcategorias()] = $result->getNome();
    	    }
    	}
    	return $this->categoriaValue;
    } 
    
    public function getSubCategoryValuesOptions(){
    	if(!$this->subCategoriaValue){
    		$repository = $this->getServiceLocator()->get("Produto\Repository\SubCategorias");
    			
    		$this->subCategoriaValue[""] = "--SELECIONE--";
    		foreach ($repository->findAll() as $result){
    			$this->subCategoriaValue[$result->getIdsubcategoria()] = $result->getNome();
    		}
    	}
    	return $this->subCategoriaValue;
    }
    
    public function indexAction() {
        $repositor = $this->getServiceLocator()->get("Produto\Repository\Produtos");
        $repositorCat = $this->getServiceLocator()->get("Produto\Repository\Categorias");        
        
        $list = $repositor->findAll();
        $page = $this->params()->fromRoute('page');
        
        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($page);
        $paginator->setDefaultItemCountPerPage(2);
        
        return new ViewModel(array("categorias"=>$repositorCat->findAll(), "produto"=>$paginator));
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
        $form = new FrmProduto;
        $select = $form->get('inputCategoria');        
        $select->setValueOptions($this->getCategoryValuesOptions());
        
        return new ViewModel(array(
            'form'    => $form
        ));
    }
    
    public function criarProdutoAction(){
        $form = new FrmProduto;        
        $comboCategoria = $form->get('inputCategoria');
        $comboCategoria->setValueOptions($this->getCategoryValuesOptions());
                
        $comboSubCategoria = $form->get('inputSubCategoria');
        $comboSubCategoria->setValueOptions($this->getSubCategoryValuesOptions());
        
        $request = $this->getRequest();
        if($request->isPost())
        {            
            $noFile = $request->getPost()->toArray();
            $File = $this->params()->fromFiles('foto');            
            $photoname = $File['name'];          
            $data = array_merge($noFile, array('foto'=>$File['name']));            
            $form->setData($data);
            
                
        	if($form->isValid())
        	{
        	    $size = new Size(array('max'=>2000000));
        	    $adpter = new Http();
        	    $adpter->setValidators(array($size), $File);
        	    
        	    if(!$adpter->isValid()){
        	    	$dataError = $adpter->getMessages();
        	    	$error = array();
        	    	foreach ($dataError as $erro){
        	    		$error[] = $erro;
        	    	}
        	    	echo "<pre>", print_r($error), "</pre>";        	    	
        	    } else {
        	        
        	        $diretorio = $request->getServer()->DOCUMENT_ROOT . '/seletoLoja/public/images/produtos/large';
        	        $adpter->setDestination($diretorio);        	                	       
        	        
        	        if($adpter->receive($_FILES['name']))
        	        { 
                        $thumbnailer = $this->getServiceLocator()->get('WebinoImageThumb');        	            
                        
        	            $small = $thumbnailer->create('public/images/produtos/large/' . $photoname, $options = array());        	                  	         
        	            $small->resize(212,159);
        	            $small->save('public/images/produtos/small/'.$photoname);
        	            
        	            /////////////////////////////////////////////////////////////////////////////////////////////////
        	            
        	            $thumbsmall = $thumbnailer->create('public/images/produtos/large/' . $photoname, $options = array());
        	            $thumbsmall->resize(86,102);
        	            $thumbsmall->save('public/images/produtos/thumb_small/'.$photoname);
        	            
        	            /////////////////////////////////////////////////////////////////////////////////////////////////
        	            
        	            $thumb = $thumbnailer->create('public/images/produtos/large/' . $photoname, $options = array());        	            
        	            $thumb->resize(50,66);        	            
        	            $thumb->save('public/images/produtos/thumb/'.$photoname);
        	            
        	        }
        	        else
        	        {
        	        	
        	        }
        	    }
        	    
        	    $service = $this->getServiceLocator()->get("Produto\Service\Produto");
        	    $service->insert($data);
        	    
        	}
        	else 
        	{
        	    echo "<pre>", print_r($form->getMessages()), "</pre>";
        		die();
        	}
        	
        	return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
        }
        
        
    }
    
    public function editarAction(){
        $repositor = $this->getServiceLocator()->get("Produto\Repository\Produtos");        
        $produto = $repositor->find($this->params()->fromRoute('id',0));
        
        $form = new FrmProduto;
        $form->get('inputCategoria')->setValueOptions($this->getCategoryValuesOptions());
        $form->get('inputCategoria')->setValue($produto->getProdutosubcategoria()->getCategorias()->getIdcategorias());
        
        $form->get('inputSubCategoria')->setValueOptions($this->getSubCategoryValuesOptions());
        $form->get('inputSubCategoria')->setValue($produto->getProdutosubcategoria()->getIdsubcategoria());
        
        $form->get('idproduto')->setValue($produto->getIdproduto());
        $form->get('titulo')->setValue($produto->getTitulo());
        $form->get('valor')->setValue($produto->getValor(true));
        $form->get('peso')->setValue($produto->getPeso());
        $form->get('comprimento')->setValue($produto->getComprimento());
        $form->get('altura')->setValue($produto->getAltura());
        $form->get('largura')->setValue($produto->getLargura());
        $form->get('ativo')->setValue($produto->getAtivo());
        $form->get('foto_atual')->setValue($produto->getFoto());
        
        
        $request = $this->getRequest();
        if($request->isPost())
        {
        	$nonFile = $request->getPost()->toArray();
        	$File = $this->params()->fromFiles('foto');
        	$data = array_merge($nonFile, array('foto'=>$File['name']));
        	$form->setData($data);
        	
        	if($form->isValid())
        	{
        	    $size = new Size(array('max'=>2000000));
        	    $adpter = new Http();
        	    $adpter->setValidators(array($size), $File['name']);
        	    
        	    if(!$adpter->isValid())
        	    {
        	    	$dataError = $adpter->getMessages();
        	    	$error = array();
        	    	foreach ($dataError as $row){
        	    		$error[] = $row;
        	    	}
        	    	$form->setMessages(array('foto'=>$error));
        	    }
        	    else 
        	    {
        	        $diretorio = $request->getServer()->DOCUMENT_ROOT . '/seletoLoja/public/images/produtos/large';
        	        $adpter->setDestination($diretorio);
        	        
        	        if($adpter->receive($File['name']))
        	        {
        	            $thumbnailer = $this->getServiceLocator()->get('WebinoImageThumb');
        	            
        	            $small = $thumbnailer->create('public/images/produtos/large/' . $photoname, $options = array());
        	            $small->resize(212,159);
        	            $small->save('public/images/produtos/small/'.$photoname);
        	             
        	            /////////////////////////////////////////////////////////////////////////////////////////////////
        	             
        	            $thumbsmall = $thumbnailer->create('public/images/produtos/large/' . $photoname, $options = array());
        	            $thumbsmall->resize(86,102);
        	            $thumbsmall->save('public/images/produtos/thumb_small/'.$photoname);
        	             
        	            /////////////////////////////////////////////////////////////////////////////////////////////////
        	             
        	            $thumb = $thumbnailer->create('public/images/produtos/large/' . $photoname, $options = array());
        	            $thumb->resize(50,66);
        	            $thumb->save('public/images/produtos/thumb/'.$photoname);
        	            
        	            $this->flashMessenger()->addMessage(array('success' => 'Foto alterado com sucesso.'));
        	        } else {
        	            $this->flashMessenger()->addMessage(array('error' => 'A foto não pode ser alterada.'));
        	        }
        	        
        	    }
        	    
        	    
        	}
        	
        	
        	
        	
        	
        }
        
        
        
        
        
        
        
        
    	return new ViewModel(array(
    	    "form" => $form,
    	    "produto" => $produto
    	));
    }
    
    public function gravarAlteracaoAction(){
        $form = new FrmProduto;
        $form->get('inputCategoria')->setValueOptions($this->getCategoryValuesOptions());
        $form->get('inputSubCategoria')->setValueOptions($this->getSubCategoryValuesOptions());
        
        $request = $this->getRequest();
        if($request->isPost())
        {
            $noFile = $request->getPost()->toArray();
            
            if($this->params()->fromPost('foto'))
            {
            	
            }
            else 
            {
            	$foto = array('foto'=>$noFile['foto_atual']);
            	unset($noFile['foto_atual']);
            	$data = array_merge($noFile, $foto);
            	echo "<pre>", print_r($data), "</pre>";
            	die();
            }
                    	
            $form->setData($data);
            
            if($form->isValid())
            {
                echo "<pre>", print_r($data), "</pre>";
                die('if');
            }
            else
            {
                echo "<pre>", print_r($form->getMessages()), "</pre>";
                die('else');
            }// fim da valicao do form            
        }// fim da verificaçao do request
    } 
    
    public function excluirAction(){
        $service = $this->getServiceLocator()->get("Produto\Service\Produto");
        if($service->delete($this->params()->fromRoute('id',0))){
            return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
        }                      
    }
    
}