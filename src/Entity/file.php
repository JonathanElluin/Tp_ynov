<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * file
 *
 * @ORM\Table(name="file")
 * @ORM\Entity
 */
class file
{
	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string")
	 * @Assert\File(mimeTypes={ "application/pdf" },
	 *     mimeTypesMessage = "Uniquement PDF"
	 * )
	 */
	private $chemin;

	/**
	 * @var proprietaire
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\User")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $proprietaire;

}

