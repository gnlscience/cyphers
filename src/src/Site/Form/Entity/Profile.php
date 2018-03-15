<?php
namespace Bundle\Site\Form\Entity;

use Bolt\Extension\BoltAuth\Auth\Form\Entity\Profile as BaseProfile;
use Symfony\Component\HttpFoundation\File\File;

class Profile extends BaseProfile
{
    /** @var string */
    protected $avatar;

    /**
     * @return string
     */
    public function getAvatar()
    {
        return  new File($this->avatar);
    }

    /**
     * @param string $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }
}