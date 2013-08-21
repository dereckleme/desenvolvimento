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
        return new ViewModel();
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
    	        return new ViewModel(array('data' => $return));
            }
            else
            {
                return $this->redirect()->toRoute('home');
            }    
    }
    
}
