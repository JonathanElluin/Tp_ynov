<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * messages
 *
 * @ORM\Table(name="messages")
 * @ORM\Entity
 */
class messages
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
     * @ORM\Column(name="Text", type="text")
     */
    private $text;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="archive", type="boolean")
	 */
	private $archive = 0;

	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\User")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $author;

	/**
	 * @var filMessages
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\fil_messages")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $filMessages;

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
     * Set text
     *
     * @param string $text
     *
     * @return messages
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

	public function getAuthor(): User
	{
		return $this->author;
	}

	public function setAuthor(User $author): void
	{
		$this->author = $author;
	}

	public function getfilMessages(): fil_messages
	{
		return $this->filMessages;
	}

	public function setfilMessages(fil_messages $filMessages): void
	{
		$this->filMessages = $filMessages;
	}

}

