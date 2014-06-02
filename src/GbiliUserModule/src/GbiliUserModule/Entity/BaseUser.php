<?php
namespace GbiliUserModule\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
class BaseUser implements UserInterface
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="uniquename", type="string", length=64, nullable=false, unique=true)
     */
    private $uniquename;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=64, nullable=false, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64, nullable=false, unique=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=64, nullable=false, unique=false)
     */
    private $role;

    public function __construct()
    {
    }

    public function isAdmin()
    {
        return $this->getRole() === 'admin';
    }

    public function getId()
    {
        return $this->id;
    }

    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setUniquename($uniquename)
    {
        $this->uniquename = $uniquename;
        return $this;
    }

    public function getUniquename()
    {
        return $this->uniquename;
    }

    public function setPassword($clearPassword)
    {
        $bcrypt = new \Zend\Crypt\Password\Bcrypt();
        $this->password = $bcrypt->create($clearPassword);
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function isThisPassword($unknownClearPassword)
    {
        $bcrypt = new \Zend\Crypt\Password\Bcrypt();
        return $bcrypt->verify($unknownClearPassword, $this->getPassword());
    }

    public function hydrate($data)
    {
        foreach ($data as $method => $param) {
            if ('id' === $method) continue;
            $method = 'set' . ucfirst($method);
            $this->$method($param);
        }
        return $this;
    }
}
