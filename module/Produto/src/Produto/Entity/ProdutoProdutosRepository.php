<?php

namespace Produto\Entity;

use Doctrine\ORM\EntityRepository;

class ProdutoProdutosRepository extends EntityRepository {
    protected $slugProduto;
    protected $slugCategoria;
    protected $slugSubcategoria;
    
    public function detalheProduto()
    {
        $qb =  $this->createQueryBuilder('i');
        $qb->select('i');
        $qb->innerJoin('Produto\Entity\ProdutoSubcategoria', 's', 'WITH', 'i.produtosubcategoria = s.idsubcategoria');
        $qb->where("s.slugSubcategoria = :slugSub");
        $qb->andWhere("i.slugProduto = :slugProduto");
        $qb->setParameters(array("slugSub" => $this->slugSubcategoria, "slugProduto" => $this->slugProduto));
            $query = $qb->getQuery();
            $results = $query->getOneOrNullResult();
        return $results;
    }
	public function setSlugProduto($slugProduto) {
		$this->slugProduto = $slugProduto;
	}

	public function setSlugCategoria($slugCategoria) {
		$this->slugCategoria = $slugCategoria;
	}

	public function setSlugSubcategoria($slugSubcategoria) {
		$this->slugSubcategoria = $slugSubcategoria;
	}

}