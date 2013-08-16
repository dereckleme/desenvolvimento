<?php
namespace DrkCorreios\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{
    public function get()
    {        
        $matriz = array();        
        $matriz['CEP'] = "05544-040";
        $matriz['Metodo'] = "listaLogradouro";
        $matriz['TipoConsulta'] = "cep";
        $matriz['StartRow'] = "1";
        $matriz['EndRow'] = "10";
        
        $curl = $this->getServiceLocator()->get('DrkCorreios\Service\DrkCorreios');        
        
        return new ViewModel(array('dados'=>json_encode($curl->requisicaoDom($matriz))));        
    }
}