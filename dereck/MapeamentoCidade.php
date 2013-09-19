<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MapeamentoCidade
 *
 * @ORM\Table(name="mapeamento_cidade")
 * @ORM\Entity
 */
class MapeamentoCidade
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idcidade", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcidade;

    /**
     * @var string
     *
     * @ORM\Column(name="nomeclatura", type="string", length=255, nullable=false)
     */
    private $nomeclatura;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255, nullable=false)
     */
    private $nome;

    /**
     * @var \MapeamentoEstado
     *
     * @ORM\ManyToOne(targetEntity="MapeamentoEstado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mapeamento_idestado", referencedColumnName="idmapeamento_estado")
     * })
     */
    private $mapeamentoestado;


}
