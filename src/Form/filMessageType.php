<?php

namespace App\Form;

use App\Entity\fil_messages;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use App\Entity\User;

class filMessageType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('title')
			->add('destinataire', EntityType::class, array(
				'class' => User::class,
				'choice_label' => 'username',
				'query_builder' => function (EntityRepository $er) use ($options) {
					return $er->createQueryBuilder('u')
						->from(User::class,'user')
						->andWhere('u.id != :user')
						->setParameter('user', $options['me']);
				},
				'label' => 'Attribuer un utilisateur ou plusieurs à la conversation (CTRL + clic gauche) : ',
				'multiple' => true,
			));
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'App\Entity\fil_messages',
			'me' => null
		));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix()
	{
		return 'fil_messages';
	}


}
