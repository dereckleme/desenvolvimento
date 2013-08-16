<?php

namespace Pagseguro\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        $viewModel = new ViewModel();
         $viewModel->setTerminal(true);
        return $viewModel;
    }
    public function compraTesteAction()
    {
    	$service = $this->getServiceLocator()->get("Pagseguro\Curl\post");
        return new ViewModel(array("codeToken" => $service->requisicao()));
    }
    public function gerarTokenAction()
    {
        $service = $this->getServiceLocator()->get("Pagseguro\Curl\post");
        $viewModel = new ViewModel(array("codeToken" => $service->requisicao()));
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    /*
     * Retorno Pagseguro Action
     */
    public function retornoAction()
    {
        $request = $this->getRequest();
            if(!$request->isPost())
            {
                $data = $request->getPost()->toArray();
                $service = $this->getServiceLocator()->get("Pagseguro\Curl\Retorno");
                $return = $service->requisicao("9131E8-2202390239FA-3664257F8AD1-FC60CF");
                $codigoUnitario = $return['code'];
                
                $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
                $repositoryRecibo = $em->getRepository("Pagseguro\Entity\PagamentoControlerecibo");
                
                if(count($repositoryRecibo->findBynpedido(array($codigoUnitario))) == 0) // nao existe
                {
                	$service = $this->getServiceLocator()->get("Pagseguro\Service\Pagseguro");
                	$service->insert(array("npedido" => $return['code'],"spagamento" => $return['status'], "fPagamento" => $return['paymentMethod']['type']));
                }
                else
                {
                	
                }
            }    
    	return new ViewModel();
    }
}

