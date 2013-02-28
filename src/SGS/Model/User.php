<?php
namespace SGS\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User implements UserInterface{

    const TYPE_AGENT   = 1;
    const TYPE_REQUESTER  = 2;
    const TYPE_DISPATCHER = 4;
    const TYPE_ADMIN = 8;
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=32)
     */
    protected $salt;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    protected $password;

    /**
     * @ORM\Column(type="integer")
     */
    protected $type;

    /**
     * @ORM\OneToMany(targetEntity="Job", mappedBy="requester")
     */
    protected $requestedJobs;

    /**
     * Creates the salt when constructed
     */
    public function __construct()
    {
        $this->requestedJobs = new ArrayCollection();
        $this->salt = md5(uniqid(null,true));
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Sets the user's hashed password
     * 
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return User
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Add type
     *
     * @param integer $type
     * @return User
     */
    public function addType($type)
    {
        $this->type = ($type | $this->type);

        return $this;
    }

    /**
     * Remove type
     *
     * @param integer $type
     * @return User
     */
    public function removeType($type)
    {
        $this->type = ($this->type & ~$type);

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }   

    /**
     * Checks if the user has the specified type
     *
     * @return boolean
     */
    public function hasType($type)
    {
        return (($this->type & $type) == true);
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function eraseCredentials()
    {
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array();
    }

    /**
     * Add requestedJobs
     *
     * @param \SGS\Model\Job $requestedJobs
     * @return User
     */
    public function addRequestedJob(Job $requestedJob, $bCallInverse = true)
    {
        if($this->requestedJobs->contains($requestedJob)){
           return $this; 
        }

        $this->requestedJobs[] = $requestedJob;

        if($bCallInverse) {
            $requestedJob->setRequester($this, false);
        }
    
        return $this;
    }

    /**
     * Remove requestedJobs
     *
     * @param \SGS\Model\Job $requestedJobs
     */
    public function removeRequestedJob(Job $requestedJob, $bCallInverse = true)
    {
        if(!$this->requestedJobs->contains($requestedJob)){
            return $this;
        }

        $this->requestedJobs->removeElement($requestedJob);

        if($bCallInverse) {
            $requestedJob->setRequester(null, false);
        }

        return $this;
    }

    /**
     * Get requestedJobs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRequestedJobs()
    {
        return $this->requestedJobs;
    }
}