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
            if($request->isPost())
            {
                $data = $request->getPost()->toArray();
                $service = $this->getServiceLocator()->get("Pagseguro\Curl\Retorno");
                $return = $service->requisicao($data['notificationCode']);
                #$return = $service->requisicao("FB9220-868A3B8A3BD6-8774E20FA2DA-E5FFA0");
                $codigoUnitario = $return['code'];
                $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
                $repositoryRecibo = $em->getRepository("Pagseguro\Entity\PagamentoControlerecibo");
                $service = $this->getServiceLocator()->get("Pagseguro\Service\Pagseguro");
                    $objectRelacional = $repositoryRecibo->findOneBynpedido(array($codigoUnitario));
                if(count($objectRelacional) == 0) // nao existe
                {
                	$service->insert(array("npedido" => $return['code'],"Setspagamento" => $return['status'], "SetfPagamento" => $return['paymentMethod']['type'], "valor" => $return['grossAmount']));
                }
                else
                {
                    $service->update(array("id" => $objectRelacional->getIdcontrolerecibo(),"Setspagamento" => $return['status'], "SetfPagamento" => $return['paymentMethod']['type']));      	     
                }
            }    
    	return new ViewModel();
    }
}

