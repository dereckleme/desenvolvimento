<?php
namespace Produto\Service;

use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator;
use Base\Service\AbstractService;

class Produto extends AbstractService {
    
    protected $subCategoriaReferenc;
    protected $servicePagamento;
    
    protected $id_produto;
    
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
		$servicoEstoque->insert(array("quantidade" => $data['quantidade']));    
		#return $this->entity;
		return $produto->getIdproduto();
	}
	
	
	/**
	 * @param field_type $id_produto
	 */
	public function setId_produto($id_produto) {
		$this->id_produto = $id_produto;
	}
	
}