<?php
namespace DrkCorreios\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;


class CurlRestController extends AbstractRestfulController
{
    public function getList()
    {        
        $matriz = array();        
        $matriz['CEP'] = "05544-040";
        $matriz['Metodo'] = "listaLogradouro";
        $matriz['TipoConsulta'] = "cep";
        $matriz['StartRow'] = "1";
        $matriz['EndRow'] = "10";
        
        $curl = $this->getServiceLocator()->get('DrkCorreios\Service\DrkCorreios');        
        $data = $curl->requisicaoDom($matriz);
        
        return new JsonModel(array('data'=>$curl->requisicaoDom($matriz)));        
    }
}