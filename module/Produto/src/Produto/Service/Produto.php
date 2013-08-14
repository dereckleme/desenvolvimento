<?php
namespace Produto\Service;

use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator;
use Base\Service\AbstractService;

class Produto extends AbstractService {
    
    protected $subCategoriaReferenc;
    protected $servicePagamento;
    
	public function __construct(EntityManager $em, $servicePagamento){
	    parent::__construct($em);
	    $this->entity = "Produto\Entity\ProdutoProdutos";
	    $this->servicePagamento = $servicePagamento;
	}
	
	public function insert(array $data) {
	    $this->setTargetEntity("Produto\Entity\ProdutoSubcategoria");
	    $this->setCampo("setProdutosubcategoria");
	    $this->setActionReference($data['inputSubCategoria']);
		$produto = parent::insert($data);
		//Add estoque.
		$this->setTargetEntity(null);
		$this->setCampo(null);
		$this->setActionReference(null);
		$servicoEstoque = $this->servicePagamento;
		$servicoEstoque->setIdProduto($produto->getIdproduto());
		$servicoEstoque->insert(array("quantidade" => 5));    
		die();
	}
}