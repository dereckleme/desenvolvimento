<?php

namespace DrkCorreios\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        $service = $this->getServiceLocator()->get("DrkCorreios\Service\Frete");
            $service->setSCepDestino("08191410");
            $service->setNVlComprimento("16");
            $service->setNVlAltura("10");
            $service->setNVlLargura("13");
            $service->setNVlPeso("2");
        $correioOb = $service->calcular();
        print $correioOb;
        die();
        $viewModel = new ViewModel();
         $viewModel->setTerminal(true);
        return $viewModel;
    }
}

