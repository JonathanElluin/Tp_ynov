<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * versement
 *
 * @ORM\Table(name="versement")
 * @ORM\Entity
 */
class versement
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
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\User")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $payeur;

	/**
	 * @var charge
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\charge")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $charge;

	/**
	 * @Assert\DateTime()
	 */
	private $dateVirement;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="decimal", precision=7, scale=2)
	 */
	private $montant;


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
     * Set type
     *
     * @param string $type
     *
     * @return versement
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

	/**
	 * @return string
	 */
	public function getMontant()
	{
		return $this->montant;
	}

	/**
	 * @param string $montant
	 */
	public function setMontant(int $montant)
	{
		$this->montant = $montant;
	}

	/**
	 * @return User
	 */
	public function getPayeur()
	{
		return $this->payeur;
	}

	/**
	 * @param User $payeur
	 */
	public function setPayeur(User $payeur)
	{
		$this->payeur = $payeur;
	}

	/**
	 * @return charge
	 */
	public function getCharge()
	{
		return $this->charge;
	}

	/**
	 * @param charge $chargeId
	 */
	public function setCharge(charge $charge)
	{
		$this->charge = $charge;
	}

	/**
	 * @return mixed
	 */
	public function getDateVirement()
	{
		return $this->dateVirement;
	}

	/**
	 * @param mixed $dateVirement
	 */
	public function setDateVirement($dateVirement)
	{
		$this->dateVirement = $dateVirement;
	}


}

