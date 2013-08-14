<?php

namespace Produto\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PagamentoControleestoque
 *
 * @ORM\Table(name="pagamento_controleestoque")
 * @ORM\Entity
 */
class PagamentoControleestoque
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idControleEstoque", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcontroleestoque;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantidade", type="integer", nullable=true)
     */
    private $quantidade;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_atualizacao", type="datetime", nullable=true)
     */
    private $dtAtualizacao;

    /**
     * @ORM\ManyToOne(targetEntity="Produto\Entity\ProdutoProdutos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Produto_idProduto", referencedColumnName="idProduto")
     * })
     */
    private $produtoproduto;
    
    
    
	/**
	 * @return the $idcontroleestoque
	 */
	public function getIdcontroleestoque() {
		return $this->idcontroleestoque;
	}

	/**
	 * @return the $quantidade
	 */
	public function getQuantidade() {
		return $this->quantidade;
	}

	/**
	 * @return the $dtAtualizacao
	 */
	public function getDtAtualizacao() {
		return $this->dtAtualizacao;
	}

	/**
	 * @return the $produtoproduto
	 */
	public function getProdutoproduto() {
		return $this->produtoproduto;
	}

	/**
	 * @param number $idcontroleestoque
	 */
	public function setIdcontroleestoque($idcontroleestoque) {
		$this->idcontroleestoque = $idcontroleestoque;
	}

	/**
	 * @param number $quantidade
	 */
	public function setQuantidade($quantidade) {
		$this->quantidade = $quantidade;
	}

	/**
	 * @param DateTime $dtAtualizacao
	 */
	public function setDtAtualizacao($dtAtualizacao) {
		$this->dtAtualizacao = $dtAtualizacao;
	}

	/**
	 * @param \Usuario\Entity\ProdutoProdutos $produtoproduto
	 */
	public function setProdutoproduto($produtoproduto) {
		$this->produtoproduto = $produtoproduto;
	}



}
