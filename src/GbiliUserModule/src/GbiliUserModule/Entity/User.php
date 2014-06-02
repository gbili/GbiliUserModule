<?php
namespace GbiliUserModule\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="gbilium__users")
 * @ORM\Entity
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="RecoverPassword", mappedBy="user")
     */
    private $recoveredpasswords;

    /**
     * @var \GbiliUserModule\Entity\UserDataInterface
     *
     * @ORM\OneToOne(targetEntity="\GbiliUserModule\Entity\UserDataInterface", inversedBy="user")
     */
    private $data;

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

    public function setData(UserDataInterface $data)
    {
        if ($data->hasUser()) {
            if($data->getUser() !== $this) {
                throw new \Exception('The data belongs to someone else');
            }
        } else {
            $data->setUser($this);
        }

        $this->data = $data;
        return $this;
    }

    public function getData()
    {
        if (!$this->hasData()) {
            throw new \Exception('No data has been set');
        }
        return $this->data;
    }

    public function hasData()
    {
        return null !== $this->data;
    }

    /**
     * Attempt to use $this->data as proxy
     *
     */
    public function __call($method, $params)
    {
        return call_user_func_array(array($this->getData(), $method), $params);
    }
}
