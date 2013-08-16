<?php
namespace Pagseguro\Service;
use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator;
use Base\Service\AbstractService;
class Pagseguro extends AbstractService
{
    public function __construct(EntityManager $em){
    	parent::__construct($em);
    	$this->entity = "Pagseguro\Entity\PagamentoControlerecibo";
    }
    public function insert(array $data)
    {
        $this->setTargetEntity(array(
            array("setTargetEntity" => "Pagseguro\Entity\UsuarioUsuarios",
                  "setCampo" => "setUsuariousuarios",
                  "setActionReference" => "1"),
            array("setTargetEntity" => "Pagseguro\Entity\PagamentoStatusFpagamento",
                      "setCampo" => "setFpagamento",
                      "setActionReference" => $data['SetfPagamento']),      
            array("setTargetEntity" => "Pagseguro\Entity\PagamentoStatusSpagamento",
                  		"setCampo" => "setSpagamento",
                  		"setActionReference" => $data['Setspagamento']),
        ));
        if($data['Setspagamento'] == 3) $data['status'] = 1;
    	parent::insert($data);
    }
    public function update(array $data)
    {
        $this->setTargetEntity(array(
        		array("setTargetEntity" => "Pagseguro\Entity\PagamentoStatusFpagamento",
        				"setCampo" => "setFpagamento",
        				"setActionReference" => $data['SetfPagamento']),
        		array("setTargetEntity" => "Pagseguro\Entity\PagamentoStatusSpagamento",
        				"setCampo" => "setSpagamento",
        				"setActionReference" => $data['Setspagamento']),
        ));
        if($data['Setspagamento'] == 3) $data['status'] = 1;
    	parent::update($data);
    }
}

?>