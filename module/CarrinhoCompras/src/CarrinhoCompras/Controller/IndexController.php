<?php

namespace CarrinhoCompras\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    private $carrinho;
    public function insertAction()
    {
        $request = $this->getRequest();
        if($request->isPost())
        {
            $data = $request->getPost()->toArray();
            $service = $this->getServiceLocator()->get("CarrinhoCompras\Service\Carrinho");
            $service->setIdProduto($data['actionAddCart']);
            $service->adiciona();
        }
        $view = new ViewModel();
        $view->setTerminal(true);
    	return $view;
    }
    public function deleteAction()
    {
        $request = $this->getRequest();
        if($request->isPost())
        {
            $data = $request->getPost()->toArray();
            $service = $this->getServiceLocator()->get("CarrinhoCompras\Service\Carrinho");
            $service->setIdProduto($data['actionAddCart']);
            $service->exclui();
        }
        return new ViewModel();
    }
    public function listAction()
    {
        return new ViewModel(array("listagem" => $this->carrinho));
    }
    public function testAction()
    {
        $service = $this->getServiceLocator()->get("Produto\Repository\Produtos");
        return new ViewModel(array("listaProdutos" => $service->findAll()));
    }
}

