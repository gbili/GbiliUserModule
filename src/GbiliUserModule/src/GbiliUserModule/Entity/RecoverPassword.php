<?php
namespace GbiliUserModule\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="recover_password")
 * @ORM\Entity
 */
class RecoverPassword 
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="recoveredpasswords")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="daterequested", type="datetime", nullable=false)
     */
    private $daterequested;

    /**
     * @var string
     *
     * @ORM\Column(name="ipaddress", type="string", nullable=false)
     */
    private $ipaddress;

    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUser(\GbiliUserModule\Entity\User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    /**
     * @ORM\PrePersist
     */
    public function setDaterequested(\DateTime $time)
    {
        $this->daterequested = $time;
    }

    /**
     * Get Created Date
     * @return \DateTime
     */
    public function getDaterequested()
    {
        return $this->daterequested;
    }

    /**
     * @param $ip
     */
    public function setIpaddress($ipaddress)
    {
        $this->ipaddress = $ipaddress;
    }

    /**
     * Ip address of the user that requested the password recovery
     * @return string
     */
    public function getIpaddress()
    {
        return $this->ipaddress;
    }
}
