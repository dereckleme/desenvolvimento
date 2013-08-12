<?php

namespace Pagamento\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class FinanceiroController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }
    public function detalhePedidoAction(){
        return new ViewModel();
    }

}

