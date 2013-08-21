<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * PagamentoControlerecibo
 *
 * @ORM\Table(name="pagamento_controlerecibo")
 * @ORM\Entity
 */
class PagamentoControlerecibo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idControleRecibo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcontrolerecibo;

    /**
     * @var string
     *
     * @ORM\Column(name="nPedido", type="string", length=255, nullable=false)
     */
    private $npedido;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_venda", type="datetime", nullable=true)
     */
    private $dtVenda;

    /**
     * @var float
     *
     * @ORM\Column(name="valor", type="decimal", nullable=true)
     */
    private $valor;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var \UsuarioUsuarios
     *
     * @ORM\ManyToOne(targetEntity="UsuarioUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Usuario_idUsuarios", referencedColumnName="idUsuario")
     * })
     */
    private $usuariousuarios;

    /**
     * @var \PagamentoStatusFpagamento
     *
     * @ORM\ManyToOne(targetEntity="PagamentoStatusFpagamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fPagamento", referencedColumnName="idStatus")
     * })
     */
    private $fpagamento;

    /**
     * @var \PagamentoStatusSpagamento
     *
     * @ORM\ManyToOne(targetEntity="PagamentoStatusSpagamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sPagamento", referencedColumnName="idStatus")
     * })
     */
    private $spagamento;


}
