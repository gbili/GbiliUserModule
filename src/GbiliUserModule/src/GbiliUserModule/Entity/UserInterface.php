<?php
namespace GbiliUserModule\Entity;

interface UserInterface
{
    public function isAdmin();

    public function getId();

    public function setRole($role);

    public function getRole();

    public function setEmail($email);

    public function getEmail();

    public function setData(UserDataInterface $data);

    public function getData();

    public function setUniquename($uniquename);

    public function setPassword($clearPassword);

    public function isThisPassword($unknownClearPassword);

    public function hydrate($data);
}
