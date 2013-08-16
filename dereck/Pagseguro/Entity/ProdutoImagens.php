<?php

namespace Pagseguro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProdutoImagens
 *
 * @ORM\Table(name="produto_imagens")
 * @ORM\Entity
 */
class ProdutoImagens
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idProduto_Imagens", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idprodutoImagens;

    /**
     * @var \Pagseguro\Entity\ProdutoProdutos
     *
     * @ORM\ManyToOne(targetEntity="Pagseguro\Entity\ProdutoProdutos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Produto_Produtos_idProduto", referencedColumnName="idProduto")
     * })
     */
    private $produtoProdutosproduto;


}
