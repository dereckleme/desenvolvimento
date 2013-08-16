<?php

namespace Pagamento\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class FinanceiroController extends AbstractActionController
{

    public function indexAction()
    {
        $service = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
            $em = $service->getRepository("Pagamento\Entity\PagamentoControleRecibo")->findAll();
        return new ViewModel(array("listaRecibos" => $em));
    }
    public function detalhePedidoAction(){
        return new ViewModel();
    }

}

