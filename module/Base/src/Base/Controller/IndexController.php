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


class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    public function categoriaAction()
    {
        $busca = $this->params()->fromRoute('categoriaslug',0);
        $repository = $this->getServiceLocator()->get('Produto\Repository\Categorias');
        $categoriaBySlug = $repository->findByslug($busca);
        
        return new ViewModel(array("produtosPorCategoria"=>$categoriaBySlug));
    }
    public function categoriaAndSubAction()
    {
        return new ViewModel();
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
    
}
