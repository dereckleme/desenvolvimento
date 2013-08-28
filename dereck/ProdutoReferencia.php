<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ProdutoReferencia
 *
 * @ORM\Table(name="produto_referencia")
 * @ORM\Entity
 */
class ProdutoReferencia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idReferencia", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idreferencia;

    /**
     * @var string
     *
     * @ORM\Column(name="nome_referencia", type="string", length=255, nullable=true)
     */
    private $nomeReferencia;


}
