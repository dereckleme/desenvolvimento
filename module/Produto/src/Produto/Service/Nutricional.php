<?php
namespace Produto\Service;

use Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class Nutricional extends AbstractService
{
    public function __construct(EntityManager $em){
    	parent::__construct($em);
    	$this->entity = "Produto\Entity\ProdutoNutricionalNomes";
    }
}