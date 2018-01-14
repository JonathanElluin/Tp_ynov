<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class messagesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	        ->add('text');
	        /*->add('visibility', ChoiceType::class, array(
		        'choices' => array('Tous' => true, 'unique' => false),
	        ))
	        ->add('destinataire', EntityType::class, array(
		        'class' => 'App:User',
		        'choice_label' => function ($user) {
			        return $user->getUsername();  // Mettre ici le nom de ta méthode à la place si tu n'as pas d'attribut n...
		        },
                'label' => 'Attribuer un utilisateur ou plusieurs à la conversation (CTRL + clic gauche) : ',
		        'multiple' => true,
                ));*/
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\messages'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_messages';
    }


}
