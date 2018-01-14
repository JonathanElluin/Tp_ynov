<?php
// src/Entity/User.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
* @ORM\Entity
* @UniqueEntity(fields="email", message="Email already taken")
* @UniqueEntity(fields="username", message="Username already taken")
*/
class User implements UserInterface
{
/**
* @ORM\Id
* @ORM\Column(type="integer")
* @ORM\GeneratedValue(strategy="AUTO")
*/
private $id;


/**
* @ORM\Column(type="string", length=255, unique=true)
* @Assert\NotBlank()
* @Assert\Email()
*/
private $email;

/**
* @ORM\Column(type="string", length=255, unique=true)
* @Assert\NotBlank()
*/
private $username;

/**
* @Assert\NotBlank()
* @Assert\Length(max=4096)
*/
private $plainPassword;

/**
*
* @ORM\Column(type="string", length=64)
*/
private $password;


/**
 * @var array
 *
 * @ORM\Column(type="json")
 */
private $roles = [];

/**
 * @return mixed
*/
public function getId()
{
	return $this->id;
}

public function getEmail()
{
	return $this->email;
}

public function setEmail($email)
{
	$this->email = $email;
}

public function getUsername()
{
	return $this->username;
}

public function setUsername($username)
{
	$this->username = $username;
}

public function getPlainPassword()
{
	return $this->plainPassword;
}

public function setPlainPassword($password)
{
	$this->plainPassword = $password;
}

public function getPassword()
{
	return $this->password;
}

public function setPassword($password)
{
	$this->password = $password;
}

public function getRoles(): array
{
	$roles = $this->roles;
	if (empty($roles)) {
		$roles[] = 'ROLE_USER';
	}
	return array_unique($roles);
}

public function setRoles(array $roles): void
{
	$this->roles = $roles;
}

public function getSalt()
{
// The bcrypt algorithm doesn't require a separate salt.
// You *may* need a real salt if you choose a different encoder.
	return null;
}

public function eraseCredentials()
{
}

public function toString()
{
	return $this->getUsername();
}
// other methods, including security methods like getRoles()
}