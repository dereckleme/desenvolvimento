<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ProdutoSubcategoria
 *
 * @ORM\Table(name="produto_subcategoria")
 * @ORM\Entity
 */
class ProdutoSubcategoria
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idSubcategoria", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idsubcategoria;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255, nullable=true)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="slug_subcategoria", type="string", length=255, nullable=true)
     */
    private $slugSubcategoria;

    /**
     * @var \ProdutoCategorias
     *
     * @ORM\ManyToOne(targetEntity="ProdutoCategorias")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Produto_idCategorias", referencedColumnName="idCategorias")
     * })
     */
    private $produtocategorias;


}
