<?php
namespace Bundle\Site\Form\Type;

use Bolt\Extension\CND\ImageService\Field\ImageServiceField;
use Bolt\Extension\CND\ImageService\Field\ImageServiceListField;
use Bolt\Extension\CND\ImageService\Service\ImageService;
use Bolt\Form\FormType\FileUploadType;
use Bolt\Storage\Field\Type\FileType;
use Bundle\Site\Config;
use Bundle\Site\Form\Entity\Profile;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Bolt\Translation\Translator as Trans;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileEditType extends \Bolt\Extension\BoltAuth\Auth\Form\Type\ProfileEditType
{
    /** @var Config */
    protected $localConfig;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('avatar', 'file', [
                'label'       => Trans::__('Avatar:'),
                'constraints' => [
                ],
                'required'    => $this->localConfig->isAvatarRequired(),
            ])
            ->add('submit', 'submit', [
                'label'   => Trans::__('Save & continue'),
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) use ($options) {
                $data = $event->getData();
                if ($data['avatar'] instanceof UploadedFile) {
                    $fileName = md5(uniqid()) . '.' . $data['avatar']->guessClientExtension();
                    $data['avatar']->move('files/avatar', $fileName);
                    $data['avatar'] = new File('avatar/' . $fileName);
                }
                $event->setData($data);
            });

    }

    public function setLocalConfig(Config $config)
    {
        $this->localConfig = $config;
    }

//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults(array(
//            'data_class' => Profile::class,
//        ));
//    }



}