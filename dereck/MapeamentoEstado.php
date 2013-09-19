<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MapeamentoEstado
 *
 * @ORM\Table(name="mapeamento_estado")
 * @ORM\Entity
 */
class MapeamentoEstado
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idmapeamento_estado", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idmapeamentoEstado;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="NOMECLATURA", type="string", length=255, nullable=false)
     */
    private $nomeclatura;


}