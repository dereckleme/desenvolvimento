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

use Zend\View\Helper\Url;


class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function categoriaAction()
    {
      
        $busca = $this->params()->fromRoute('categoriaslug',0);
        $page = $this->params()->fromRoute('page');
        
        $repository = $this->getServiceLocator()->get('Produto\Repository\Categorias');
        $categoriaBySlug = $repository->findByslug($busca);
        
        #$paginator = new Paginator(new ArrayAdapter($teste));
        #$paginator->setCurrentPageNumber($page);
        #$paginator->setDefaultItemCountPerPage(1);
        
        return new ViewModel(array("produtosPorCategoria"=>$categoriaBySlug, 'page'=>$page));
    }
    
    public function categoriaAndSubAction()
    {
        $busca = $this->params()->fromRoute('subcategoriaslugSub',0);
        $repository = $this->getServiceLocator()->get('Produto\Repository\SubCategorias');
        $subCatBySlug = $repository->findBySlugSubcategoria($busca);
        
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
        $repository = $this->getServiceLocator()->get("Produto\Repository\Produtos");                
        $repository->setSearch($this->params()->fromQuery('term'));
        $resultado = $repository->buscaProdutos();
        
        #echo $this->params()->fromQuery('term'), "\n";
        echo "<pre>", print_r($resultado), "</pre>";die();
        
       
        /*
        $viewModel = new ViewModel(array('termos' => json_encode($resp))); // chama uma view
        $viewModel->setTerminal(true); // desativa layout.phtml
        return $viewModel;
        */
        
    	return new ViewModel();
    }
    
    public function buscaDeProdutosAction()
    {
        die('busca');
        echo $this->params()->fromQuery('search');
        return new ViewModel();
    }
    
}