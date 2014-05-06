<?php
namesapace GbiliUserModule\Entity;

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

    public function setMedia(\Blog\Entity\Media $media = null);

    public function getMedia();

    public function hasMedia();

    public function setUser(User $user);

    public function getUser();

    public function setDate(\DateTime $time);

    public function getDate();
}
