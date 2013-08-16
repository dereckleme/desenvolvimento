<?php

namespace Pagseguro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuarioUsuarios
 *
 * @ORM\Table(name="usuario_usuarios")
 * @ORM\Entity
 */
class UsuarioUsuarios
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idUsuario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idusuario;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=255, nullable=true)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="senha", type="string", length=255, nullable=true)
     */
    private $senha;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_cadastro", type="datetime", nullable=true)
     */
    private $dtCadastro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_ativacao", type="datetime", nullable=true)
     */
    private $dtAtivacao;

    /**
     * @var integer
     *
     * @ORM\Column(name="nivel", type="integer", nullable=false)
     */
    private $nivel;


}
