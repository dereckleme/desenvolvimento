<?php

namespace Pagamento\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PagamentoStatusSpagamento
 *
 * @ORM\Table(name="pagamento_status_spagamento")
 * @ORM\Entity
 */
class PagamentoStatusSpagamento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idStatus", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idstatus;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=45, nullable=true)
     */
    private $titulo;


}
