<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * fil_messages
 *
 * @ORM\Table(name="fil_messages")
 * @ORM\Entity(repositoryClass="App\Repository\conversationRepository")
 */
class fil_messages
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
     * @Assert\NotBlank()
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

	/**
	 * @var destinataire
	 *
	 * @ORM\ManyToMany(targetEntity="App\Entity\User")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $destinataire;


	public function __construct()
	{
		$this->destinataire = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return fil_messages
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

	/*public function addDestinataire(User ...$destinataire): void
	{
		foreach ($destinataire as $destinataire) {
			if (!$this->destinataire->contains($destinataire)) {
				$this->destinataire->add($destinataire);
			}
		}
	}

	public function removeDestinataire(User $destinataire): void
	{
		$this->destinataire->removeElement($destinataire);
	}

	public function getDestinataire(): Collection
	{
		return $this->destinataire;
	}*/

	/**
	 * Get destinataires
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getDestinataire()
	{
		return $this->destinataire;
	}

	public function setdestinataire(User $destinataire): void
	{
		$this->destinataire = $destinataire;
	}

	public function addDestinataire(User $destinataire): void
	{
		if (!$this->destinataire->contains($destinataire)) {
			$this->destinataire->add($destinataire);
		}
	}
}

