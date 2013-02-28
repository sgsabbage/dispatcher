<?php
namespace SGS\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="job")
 */
class Job {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * Name of the job
     *
     * @ORM\Column(type="string",length=255)
     * @var string
     * 
     */
    private $name;

    /**
     * User object that requested the job
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="requestedJobs")
     * @var User
     */
    private $requester;

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
     * Set name
     *
     * @param string $name
     * @return Job
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set requester
     *
     * @param \SGS\Model\User $requester
     * @param boolean $bCallInverse
     * @return Job
     */
    public function setRequester(\SGS\Model\User $requester = null, $bCallInverse = true)
    {
        if($this->requester != null && $this->requester != $requester) {
            $this->requester->removeRequestedJob($this,false);
        }

        $this->requester = $requester;
        
        if($requester != null && $bCallInverse){
            $this->requester->addRequestedJob($this,false);
        }

        return $this;
    }

    /**
     * Get requester
     *
     * @return \SGS\Model\User 
     */
    public function getRequester()
    {
        return $this->requester;
    }
}