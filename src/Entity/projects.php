<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * projects
 *
 * @ORM\Table(name="projects")
 * @ORM\Entity(repositoryClass="App\Repository\projectRepository")
 */
class projects
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
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="description", type="string", length=255)
	 */
	private $description;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="statut", type="string")
	 */
	private $statut;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="dateStart", type="datetime")
	 */
	private $dateStart;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="dateEnd", type="datetime")
	 */
	private $dateEnd;

	/**
	 * @var fil_discussion
	 *
	 * @ORM\OneToOne(targetEntity="App\Entity\fil_messages")
	 * @ORM\JoinColumn(nullable=true)
	 */
	private $filDiscussion;

	/**
	 * @ORM\Column(type="string")
	 * @Assert\File(mimeTypes={ "application/pdf" },
	 *     mimeTypesMessage = "Uniquement PDF"
	 * )
	 */
	private $joinFile;

	/**
	 * @var proprietaire
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\User")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $proprietaire;

	/**
	 * @var utilisateur
	 *
	 * @ORM\ManyToMany(targetEntity="App\Entity\User")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $utilisateurs;

	/**
	 * @var contrat
	 *
	 * @ORM\OneToOne(targetEntity="App\Entity\contrat")
	 * @ORM\JoinColumn(nullable=true)
	 */
	private $contrat;

	public function __construct()
	{
		$this->utilisateurs = new ArrayCollection();
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName(string $name)
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription(string $description)
	{
		$this->description = $description;
	}

	/**
	 * @return string
	 */
	public function getStatut()
	{
		return $this->statut;
	}

	/**
	 * @param string $statut
	 */
	public function setStatut(string $statut)
	{
		$this->statut = $statut;
	}

	/**
	 * @return string
	 */
	public function getDateStart()
	{
		return $this->dateStart;
	}

	/**
	 * @param string $dateStart
	 */
	public function setDateStart(dateTime $dateStart)
	{
		$this->dateStart = $dateStart;
	}

	/**
	 * @return string
	 */
	public function getDateEnd()
	{
		return $this->dateEnd;
	}

	/**
	 * @param string $dateEnd
	 */
	public function setDateEnd(dateTime $dateEnd)
	{
		$this->dateEnd = $dateEnd;
	}

	/**
	 * @return mixed
	 */
	public function getJoinFile()
	{
		return $this->joinFile;
	}

	/**
	 * @param mixed joinFile
	 */
	public function setJoinFile($joinFile)
	{
		$this->joinFile = $joinFile;
		return $this;
	}

	public function getUtilisateur()
	{
		return $this->utilisateurs;
	}

	public function setUtilisateur(User $utilisateurs): void
	{
		$this->utilisateurs = $utilisateurs;
	}

	public function getContrat()
	{
		return $this->utilisateurs;
	}

	public function setContrat(contrat $contrat): void
	{
		$this->contrat = $contrat;
	}

	public function getfilDiscussion()
	{
		return $this->utilisateurs;
	}

	public function setfilDiscussion(fil_messages $filDiscussion): void
	{
		$this->filDiscussion = $filDiscussion;
	}
}

