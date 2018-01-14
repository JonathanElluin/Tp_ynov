<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class projectsType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name')
			->add('description')
			->add('statut', ChoiceType::class, array(
				'choices'  => array(
					'en discussion' => 'en discussion',
					"en attente d'exécution" => "en attente d'exécution",
					'exécuté' => 'exécuté',
				),
			))
			->add('dateStart', DateType::class, array(
				'widget' => 'single_text',
				'html5' => true,
			))
			->add('dateEnd', DateType::class, array(
				'widget' => 'single_text',
				'html5' => true,
			))
			->add('joinFile', FileType::class, array('label' => 'fichier à joindre (PDF uniquement)'))
			->add('utilisateur', EntityType::class, array(
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
			'data_class' => 'App\Entity\projects',
			'me' => null
		));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix()
	{
		return 'app_projects';
	}


}
