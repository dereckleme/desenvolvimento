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
	
	/*public function insert(array $data) {
		#$slug = strtolower($data['titulo']);
		
		$entity = new $this->entity($data);
		
		(new Hydrator\ClassMethods())->hydrate($data, $entity);
		
		$subcategoria = $this->em->getReference("Produto\Entity\ProdutoSubcategoria", $data['inputSubCategoria']);
		$entity->setProdutosubcategoria($subcategoria);
		#$entity->setSlugProduto(str_replace(" ", "-", $slug));
	
		$this->em->persist($entity);
		$this->em->flush();
		return $entity;
	
	}*/
	
	public function insert(array $data) {
	    $this->setTargetEntity("Produto\Entity\ProdutoSubcategoria");
	    $this->setCampo("setProdutosubcategoria");
	    $this->setActionReference($data['inputSubCategoria']);
		parent::insert($data);
	}
}