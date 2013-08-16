<?php

namespace Pagseguro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PagamentoControlepedido
 *
 * @ORM\Table(name="pagamento_controlepedido")
 * @ORM\Entity
 */
class PagamentoControlepedido
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idPagamento_ControlePedido", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpagamentoControlepedido;

    /**
     * @var \Pagseguro\Entity\PagamentoControlerecibo
     *
     * @ORM\ManyToOne(targetEntity="Pagseguro\Entity\PagamentoControlerecibo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idControleRecibo", referencedColumnName="idControleRecibo")
     * })
     */
    private $idcontrolerecibo;

    /**
     * @var \Pagseguro\Entity\ProdutoProdutos
     *
     * @ORM\ManyToOne(targetEntity="Pagseguro\Entity\ProdutoProdutos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Produtos_idProduto", referencedColumnName="idProduto")
     * })
     */
    private $produtosproduto;


}
