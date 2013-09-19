<?php



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
     * @var integer
     *
     * @ORM\Column(name="Destaque", type="integer", nullable=false)
     */
    private $destaque;

    /**
     * @var float
     *
     * @ORM\Column(name="peso", type="decimal", nullable=false)
     */
    private $peso;

    /**
     * @var integer
     *
     * @ORM\Column(name="Comprimento", type="integer", nullable=false)
     */
    private $comprimento;

    /**
     * @var integer
     *
     * @ORM\Column(name="altura", type="integer", nullable=false)
     */
    private $altura;

    /**
     * @var integer
     *
     * @ORM\Column(name="largura", type="integer", nullable=false)
     */
    private $largura;

    /**
     * @var integer
     *
     * @ORM\Column(name="acessos", type="integer", nullable=true)
     */
    private $acessos;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ativo", type="boolean", nullable=false)
     */
    private $ativo;

    /**
     * @var \ProdutoSubcategoria
     *
     * @ORM\ManyToOne(targetEntity="ProdutoSubcategoria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Produto_idSubcategoria", referencedColumnName="idSubcategoria")
     * })
     */
    private $produtosubcategoria;


}
