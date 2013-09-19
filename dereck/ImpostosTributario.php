<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ImpostosTributario
 *
 * @ORM\Table(name="impostos_tributario")
 * @ORM\Entity
 */
class ImpostosTributario
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idtributario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtributario;

    /**
     * @var \MapeamentoEstado
     *
     * @ORM\ManyToOne(targetEntity="MapeamentoEstado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mapeamento_idestado", referencedColumnName="idmapeamento_estado")
     * })
     */
    private $mapeamentoestado;

    /**
     * @var \ProdutoProdutos
     *
     * @ORM\ManyToOne(targetEntity="ProdutoProdutos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Produto_idProduto", referencedColumnName="idProduto")
     * })
     */
    private $produtoproduto;


}
