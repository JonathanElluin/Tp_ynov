<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\charge;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VersementType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('payeur', EntityType::class, array(
				'class' => 'App:User',
				'choice_label' => function ($user) {
					return $user->getUsername();
				},
				'label' => 'Le payeur: ',
				'multiple' => false,
				))
			->add('type', ChoiceType::class, array(
				'choices'  => array(
					"virement bancaire" => "virement bancaire",
					'chèque' => 'chèque',
				),
			))
			->add('charge', EntityType::class, array(
				'class' => 'App:charge',
				'choice_label' => function ($charge) {
					return $charge->getTitle();
				},
				'label' => 'La charge liée: ',
				'multiple' => false,
			))
			->add('dateVirement', DateType::class, array(
				'widget' => 'single_text',
				'html5' => true,
			))
			->add('montant',MoneyType::class, array(

				'required' => true
			));
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'App\Entity\versement'
		));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix()
	{
		return 'versement';
	}


}
