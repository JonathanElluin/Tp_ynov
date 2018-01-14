<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * charge
 *
 * @ORM\Table(name="charge")
 * @ORM\Entity(repositoryClass="App\Repository\chargeRepository")
 */
class charge
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
	 * @ORM\Column(name="title", type="string", length=255)
	 */
	private $title;


    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=2, scale=0)
     */
    private $price;

	/**
	 * @Assert\DateTime()
	 */
    private $dateCharge;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="statut", type="boolean")
	 */
	private $statut = 0;

	/**
	 * @var proprio
	 *
	 * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="charge")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $proprio;

	/**
	 * @ORM\Column(type="string")
	 * @Assert\File(mimeTypes={ "application/pdf" },
	 *     mimeTypesMessage = "Uniquement PDF"
	 * )
	 */
	private $joinFile;

	/**
	 * @var contrat
	 *
	 * @ORM\OneToOne(targetEntity="App\Entity\contrat")
	 * @ORM\JoinColumn(nullable=true)
	 */
	private $contrat;

	public function __construct()
	{
		$this->prorio = new ArrayCollection();
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

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return charge
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

	/**
	 * Set date
	 *
	 * @param string $date
	 *
	 * @return chargeCharge
	 */
	public function setDateCharge($dateCharge)
	{
		$this->date = $dateCharge;

		return $this;
	}

	/**
	 * Get date
	 *
	 * @return string
	 */
	public function getDateCharge()
	{
		return $this->dateCharge;
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
	public function setStatut($statut)
	{
		$this->statut = $statut;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function getProprio()
	{
		return $this->destinataire;
	}

	public function setProprio(User $proprio): void
	{
		$this->proprio = $proprio;
	}
}

