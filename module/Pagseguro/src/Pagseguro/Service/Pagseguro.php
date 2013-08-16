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
    	$this->setTargetEntity("Pagseguro\Entity\UsuarioUsuarios");
    	$this->setCampo("setUsuariousuarios");
    	$this->setActionReference("1");
    	parent::insert($data);
    }
}

?>