<?php

namespace Produto\Entity;

use Doctrine\ORM\EntityRepository;

class ProdutoProdutosRepository extends EntityRepository {
    protected $slugProduto;
    protected $slugCategoria;
    protected $slugSubcategoria;
    protected $search; 
    
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
    
    public function produtosRelacionados()
    {
        $qb =  $this->createQueryBuilder('i');
        $qb->select('i');
        $qb->innerJoin('Produto\Entity\ProdutoSubcategoria', 's', 'WITH', 'i.produtosubcategoria = s.idsubcategoria');
        $qb->where("s.slugSubcategoria = :slugSub");
        $qb->andWhere("i.slugProduto != :slugProduto");
        $qb->setParameters(array("slugSub" => $this->slugSubcategoria, "slugProduto" => $this->slugProduto));
        $query = $qb->getQuery();
        $results = $query->getResult();
        return $results;
    }
    
    public function buscaProdutos(){
        $qb =  $this->createQueryBuilder('i');
        $qb->select('i.titulo');
        #$qb->innerJoin('Produto\Entity\ProdutoSubcategoria', 's', 'WITH', 'i.produtosubcategoria = s.idsubcategoria');
        #$qb->innerJoin('Produto\Entity\ProdutoCategorias', 'c', 'WITH', 's.categorias = c.idcategorias');
        $qb->where($qb->expr()->like('i.titulo', '?1'));
        #$qb->orWhere($qb->expr()->like('c.nome', ':search'));
        $qb->setParameter(1, "%$this->search%");
        $query = $qb->getQuery();        
        $results = $query->getResult();
        echo "<pre>", print($query->getDQL()), "</pre>";
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
	
	public function setSearch($search) {
		$this->search = $search;
	}

    
	
}