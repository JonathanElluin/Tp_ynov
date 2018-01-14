<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * contrat
 *
 * @ORM\Table(name="contrat")
 * @ORM\Entity
 */
class contrat
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
     * @return contrat
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

	/**
	 * @return string
	 */
	public function getDateStart(): string
	{
		return $this->dateStart;
	}

	/**
	 * @param string $dateStart
	 */
	public function setDateStart(string $dateStart)
	{
		$this->dateStart = $dateStart;
	}

	/**
	 * @return string
	 */
	public function getDateEnd(): string
	{
		return $this->dateEnd;
	}

	/**
	 * @param string $dateEnd
	 */
	public function setDateEnd(string $dateEnd)
	{
		$this->dateEnd = $dateEnd;
	}
}

