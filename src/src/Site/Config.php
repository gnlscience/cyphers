<?php
/**
 * Created by PhpStorm.
 * User: Clayton
 * Date: 3/4/2018
 * Time: 8:13 PM
 */

namespace Bundle\Site;


class Config
{
    /** @var boolean */
    protected $avatarRequired;

    /**
     * Constructor.
     *
     * @param array $config
     */
    public function __construct($config)
    {
        $profileFields = $config['meta_fields']['profile'];
        $this->avatarRequired = $profileFields['avatar']['required'];
    }

    /**
     * @return bool
     */
    public function isAvatarRequired()
    {
        return $this->avatarRequired;
    }

    /**
     * @param bool $avatarRequired
     */
    public function setAvatarRequired($avatarRequired)
    {
        $this->avatarRequired = $avatarRequired;
    }
}