<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Estado
 *
 * @ORM\Table(name="estado")
 * @ORM\Entity
 */
class Estado
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=75, nullable=true)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="uf", type="string", length=5, nullable=true)
     */
    private $uf;

    /**
     * @var integer
     *
     * @ORM\Column(name="pais", type="integer", nullable=true)
     */
    private $pais;


}
