<?php

namespace App\EntityListener;


use App\Entity\User;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\PrePersist;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListener
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function prePersist(User $user)
    {

        $this->encodePassword($user);
    }

    public function preUpdate(User $user)
    {
        $this->encodePassword($user);
    }

    /**
     * Encode le password sous la base du plainPassword
     *
     * @param User $user
     * @return void
     */
    public function encodePassword(User $user)
    {

        if ($user->getPlainPassword() === null) {
            return;
        }

        $user->setPassword(
            $this->hasher->hashPassword($user, $user->getPlainPassword())
        );

        // $user->setPlainPassword(null);
    }
}
