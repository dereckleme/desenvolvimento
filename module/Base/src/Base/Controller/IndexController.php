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
use Zend\Paginator\Paginator as ZendPaginator,
    Zend\Paginator\Adapter\ArrayAdapter;


use Zend\View\Helper\Url;


class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function categoriaAction()
    {      
        $page = ( $this->params()->fromRoute('page') == "" || $this->params()->fromRoute('page') == 0) ? 1 :  ( ( $this->params()->fromRoute('page') - 1 ) * 1);        
        $busca = $this->params()->fromRoute('categoriaslug',0);
        
        $repository = $this->getServiceLocator()->get("Produto\Repository\Produtos");
        $repository->setSlugCategoria($busca);
        $countCategoria = $repository->categoriaCountRow();
        $categoriaBySlug = $repository->productForCategory(1, $page);        
        
        $paginator = new ZendPaginator(new ArrayAdapter($countCategoria));
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'));
        $paginator->setDefaultItemCountPerPage(1);
        
        return new ViewModel(array("produtosPorCategoria"=>$categoriaBySlug, 'page'=>$paginator));
    }
    
    public function categoriaAndSubAction()
    {
        $slugCatBusca = $this->params()->fromRoute('categoriaslug',0);
        $slugSubcatBusca = $this->params()->fromRoute('subcategoriaslugSub',0);
        
        $repository = $this->getServiceLocator()->get('Produto\Repository\Produtos');
        $repository->setSlugCategoria($slugCatBusca);
        $repository->setSlugSubcategoria($slugSubcatBusca);
        $subCatBySlug = $repository->productForCatAndSub();
                
        return new ViewModel(array('produtosPorSubCategoria'=>$subCatBySlug));
    }
    
    public function produtoAction()
    {
        $params = $this->params();
        $repository = $this->getServiceLocator()->get("Produto\Repository\Produtos");
            $repository->setSlugProduto($params->fromRoute("produtoSlug"));
            $repository->setSlugSubcategoria($params->fromRoute("subcategoriaslugSub"));
            $return = $repository->detalheProduto();
            if(count($return) == 1)
            {
                $relacionados =  $repository->produtosRelacionados();
    	        return new ViewModel(array('detalheProduto' => $return,'produtosRelacionados' => $relacionados ));
            }
            else
            {
                return $this->redirect()->toRoute('home');
            }    
    }
    
    public function autocompleteAction()
    {
        if($this->params()->fromQuery('term') != "")
        {
            $repository = $this->getServiceLocator()->get("Produto\Repository\Produtos");                
            $repository->setSearch($this->params()->fromQuery('term'));
            $resultado = $repository->buscaProdutosAutoComplete();
            
            if(count($resultado))
            {
                $i = 1;
                foreach($resultado as $values)
                {
                    foreach($values as $key => $value)
                    {
                        if($i == 1)
                        {
                            $termos["label"] = $value;
                        }
                        else
                        {   
                            $termos["label$i"] = $value;                        
                        }                    
                        $i++;
                    }            	
                }            
                $termos = json_encode($termos);
            }
            else
            {
                $termos = json_encode(array("label"=>"não há sugestões"));
            }
            
            $viewModel = new ViewModel(array('termos' => $termos)); // chama uma view
            $viewModel->setTerminal(true); // desativa layout.phtml
            return $viewModel;
            
            
        	#return new ViewModel();
        }
        else
        {
            return $this->redirect()->toRoute('home');
        }
        
    }
    
    public function buscaDeProdutosAction()
    {
        $busca =  $this->params()->fromQuery('p');
        
        $repository = $this->getServiceLocator()->get("Produto\Repository\Produtos");
        $repository->setSearch($busca);
        $resultado = $repository->resultadoBusca();
        
        if(count($resultado) > 0)
        {
            return new ViewModel(array("resultado"=>$resultado));
        }
        else
        {
            return new ViewModel(array("semresultado"=>"não resultados"));
        }
        
    }
    
}