<?php
namespace GbiliUserModule\Entity;

/**
 *
 */
interface ProfileInterface 
{
    public function getId();

    public function setFirstname($firstname);

    public function getFirstname();

    public function setSurname($surname);

    public function getSurname();

    public function setMedia(\GbiliMediaEntityModule\Entity\MediaInterface $media = null);

    public function getMedia();

    public function hasMedia();

    public function setMediaData(\GbiliMediaEntityModule\Entity\MediaDataInterface $mediadata = null);

    public function getMediaData();

    public function hasMediaData();

    public function setUser(UserInterface $user);

    public function getUser();

    public function setUserData(UserDataInterface $userdata);

    public function getUserData();

    public function setDate(\DateTime $time);

    public function getDate();
}
