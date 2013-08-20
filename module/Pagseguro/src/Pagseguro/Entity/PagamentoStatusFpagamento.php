<?php

namespace Pagseguro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PagamentoStatusFpagamento
 *
 * @ORM\Table(name="pagamento_status_fpagamento")
 * @ORM\Entity
 */
class PagamentoStatusFpagamento
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
    
	public function getIdstatus() {
		return $this->idstatus;
	}

	public function getTitulo() {
		return $this->titulo;
	}

	public function setIdstatus($idstatus) {
		$this->idstatus = $idstatus;
	}

	public function setTitulo($titulo) {
		$this->titulo = $titulo;
	}


    
}