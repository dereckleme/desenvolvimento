<?php

namespace Pagseguro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProdutoProdutos
 *
 * @ORM\Table(name="produto_produtos")
 * @ORM\Entity
 */
class ProdutoProdutos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idProduto", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idproduto;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255, nullable=true)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="slug_produto", type="string", length=255, nullable=true)
     */
    private $slugProduto;

    /**
     * @var float
     *
     * @ORM\Column(name="valor", type="decimal", nullable=true)
     */
    private $valor;

    /**
     * @var \Pagseguro\Entity\ProdutoSubcategoria
     *
     * @ORM\ManyToOne(targetEntity="Pagseguro\Entity\ProdutoSubcategoria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Produto_idSubcategoria", referencedColumnName="idSubcategoria")
     * })
     */
    private $produtosubcategoria;


}
