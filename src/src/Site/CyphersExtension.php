<?php
namespace Bundle\Site;


use Bolt\Events\AccessControlEvent;
use Bolt\Extension\Bolt\BoltForms\Event\BoltFormsEvents;
use Bolt\Extension\Bolt\BoltForms\Event\ProcessorEvent;
use Bolt\Extension\BoltAuth\Auth\Event\AuthEvents;
use Bolt\Extension\BoltAuth\Auth\Event\AuthProfileEvent;
use Bolt\Extension\BoltAuth\Auth\Event\FormBuilderEvent;
use Bolt\Extension\BoltAuth\Auth\Exception\AccountVerificationException;
use Bolt\Extension\BoltAuth\Auth\Form\AuthForms;
use Bolt\Extension\SimpleExtension;
use League\Flysystem\Exception;
use Silex\Application;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class CyphersExtension extends SimpleExtension
{

    /**
     * {@inheritdoc}
     */
    protected function registerTwigPaths()
    {
        return [
            'templates/admin'   => ['position' => 'prepend', 'namespace' => 'MembersAdmin'],
            'templates/profile' => ['position' => 'prepend'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function subscribe(EventDispatcherInterface $dispatcher)
    {
        $dispatcher->addListener(BoltFormsEvents::SUBMISSION_PRE_PROCESSOR, array($this, 'memberAuth'));
        $dispatcher->addListener(AuthEvents::AUTH_PROFILE_PRE_SAVE, [$this, 'onProfileSave']);
        $dispatcher->addListener(FormEvents::PRE_SET_DATA, [$this, 'onProfileSaveSetData']);
        $dispatcher->addListener(FormBuilderEvent::BUILD, [$this, 'onRequest']);
    }

    public function onProfileSaveSetData(FormEvent $event){
        echo "hghj";die();
    }

    public function memberAuth(ProcessorEvent $event)
    {


        $authSession = $this->container['auth.session'];
        if (!$authSession->hasAuthorisation()) {
            throw new AccountVerificationException();
        }
    }

    /**
     * Tell Members what fields we want to persist.
     *
     * @param AuthProfileEvent $event
     */
    public function onProfileSave(AuthProfileEvent $event)
    {
        $config = $this->getConfig();
        $event->addMetaEntryNames(array_keys($config['meta_fields']['profile']));
    }
    /**
     * @param FormBuilderEvent $event
     */
    public function onRequest(FormBuilderEvent $event)
    {
        if ($event->getName() !== AuthForms::PROFILE_EDIT && $event->getName() !== AuthForms::PROFILE_VIEW) {
            return;
        }
        $app = $this->getContainer();
        $localConfig = new Config($this->getConfig());
        $type = new Form\Type\ProfileEditType($app['auth.config']);
        $type->setLocalConfig($localConfig);
        $event->setType($type);
        $event->setEntityClass(Form\Entity\Profile::class);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultConfig()
    {
        return [
            'meta_fields' => [
                'profile' => [
                    'avatar' => [
                        'required' => true
                    ]
                ],
            ],
        ];
    }
}