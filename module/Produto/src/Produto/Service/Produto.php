<?php
namespace Produto\Service;

use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator;
use Base\Service\AbstractService;

class Produto extends AbstractService {
    
    protected $subCategoriaReferenc;
    
	public function __construct(EntityManager $em){
	    parent::__construct($em);
		$this->entity = "Produto\Entity\ProdutoProdutos";
	}
	
	public function insert(array $data) {
	    $this->setTargetEntity("Produto\Entity\ProdutoSubcategoria");
	    $this->setCampo("setProdutosubcategoria");
	    $this->setActionReference($data['inputSubCategoria']);
		parent::insert($data);
	}
}