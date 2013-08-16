<?php

namespace Pagamento\Entity;

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
     * @var \Pagamento\Entity\PagamentoControlerecibo
     *
     * @ORM\ManyToOne(targetEntity="Pagamento\Entity\PagamentoControlerecibo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idControleRecibo", referencedColumnName="idControleRecibo")
     * })
     */
    private $idcontrolerecibo;

    /**
     * @var \Pagamento\Entity\ProdutoProdutos
     *
     * @ORM\ManyToOne(targetEntity="Pagamento\Entity\ProdutoProdutos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Produtos_idProduto", referencedColumnName="idProduto")
     * })
     */
    private $produtosproduto;


}
