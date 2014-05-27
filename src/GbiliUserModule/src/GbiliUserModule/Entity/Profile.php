<?php
namespace GbiliUserModule\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="profiles")
 * @ORM\Entity
 */
class Profile implements ProfileInterface
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
     * @ORM\Column(name="firstname", type="string", length=64, nullable=false, unique=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=64, nullable=true, unique=false)
     */
    private $surname;

    /**
     *
     * @ORM\OneToOne(targetEntity="\GbiliUserModule\Entity\UserDataInterface", mappedBy="profile", cascade={"persist"})
     */
    private $userdata;

    /**
     * @ORM\ManyToOne(targetEntity="\GbiliUserModule\Entity\MediaInterface", inversedBy="profiles")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     */
    private $media;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     *
     */
    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setMedia(\Blog\Entity\Media $media = null)
    {
        $this->media = $media;
    }

    public function getMedia()
    {
        return $this->media;
    }

    public function hasMedia()
    {
        return $this->media instanceof \Blog\Entity\Media;
    }

    public function setUserData(UserDataInterface $userdata)
    {
        $userdata->setProfile($this);
        $this->userdata = $userdata;
        return $this;
    }

    public function getUserData()
    {
        return $this->userdata;
    }

    public function setUser(UserInterface $user)
    {
        $this->setUserData($user->getData());
        return $this;
    }

    public function getUser()
    {
        return $this->getUserData()->getUser();
    }

    /**
     * @ORM\PrePersist
     */
    public function setDate(\DateTime $time)
    {
        $this->date = $time;
    }

    /**
     * Get Created Date
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
