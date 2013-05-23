<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nezuvian
 * Date: 2013.05.13.
 * Time: 23:46
 * To change this template use File | Settings | File Templates.
 */

namespace VAK\StarsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="vote")
 */
class Vote {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="VAK\StarsBundle\Entity\User", inversedBy="votes_for_user")
     * @ORM\JoinColumn(name="voted_user_id", referencedColumnName="id")
     */
    protected $voted_user;

    /**
     * @ORM\ManyToOne(targetEntity="VAK\StarsBundle\Entity\User", inversedBy="votes_by_user")
     * @ORM\JoinColumn(name="voter_user_id", referencedColumnName="id")
     */
    protected $voter_user;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $voter_points_before;

    /**
     * @var
     * @ORM\Column(type="integer")
     */
    protected $voter_points_after;

    /**
     * @var
     * @ORM\Column(type="integer")
     */
    protected $voted_points_before;

    /**
     * @var
     * @ORM\Column(type="integer")
     */
    protected $voted_points_after;

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
     * Set voted_user
     *
     * @param \VAK\StarsBundle\Entity\User $votedUser
     * @return Vote
     */
    public function setVotedUser(\VAK\StarsBundle\Entity\User $votedUser = null)
    {
        $this->voted_user = $votedUser;
    
        return $this;
    }

    /**
     * Get voted_user
     *
     * @return \VAK\StarsBundle\Entity\User 
     */
    public function getVotedUser()
    {
        return $this->voted_user;
    }

    /**
     * Set voter_user
     *
     * @param \VAK\StarsBundle\Entity\User $voterUser
     * @return Vote
     */
    public function setVoterUser(\VAK\StarsBundle\Entity\User $voterUser = null)
    {
        $this->voter_user = $voterUser;
    
        return $this;
    }

    /**
     * Get voter_user
     *
     * @return \VAK\StarsBundle\Entity\User 
     */
    public function getVoterUser()
    {
        return $this->voter_user;
    }

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;


    /**
     * Set voter_points_before
     *
     * @param integer $voterPointsBefore
     * @return Vote
     */
    public function setVoterPointsBefore($voterPointsBefore)
    {
        $this->voter_points_before = $voterPointsBefore;
    
        return $this;
    }

    /**
     * Get voter_points_before
     *
     * @return integer 
     */
    public function getVoterPointsBefore()
    {
        return $this->voter_points_before;
    }

    /**
     * Set voter_points_after
     *
     * @param integer $voterPointsAfter
     * @return Vote
     */
    public function setVoterPointsAfter($voterPointsAfter)
    {
        $this->voter_points_after = $voterPointsAfter;
    
        return $this;
    }

    /**
     * Get voter_points_after
     *
     * @return integer 
     */
    public function getVoterPointsAfter()
    {
        return $this->voter_points_after;
    }

    /**
     * Set voted_points_before
     *
     * @param integer $votedPointsBefore
     * @return Vote
     */
    public function setVotedPointsBefore($votedPointsBefore)
    {
        $this->voted_points_before = $votedPointsBefore;
    
        return $this;
    }

    /**
     * Get voted_points_before
     *
     * @return integer 
     */
    public function getVotedPointsBefore()
    {
        return $this->voted_points_before;
    }

    /**
     * Set voted_points_after
     *
     * @param integer $votedPointsAfter
     * @return Vote
     */
    public function setVotedPointsAfter($votedPointsAfter)
    {
        $this->voted_points_after = $votedPointsAfter;
    
        return $this;
    }

    /**
     * Get voted_points_after
     *
     * @return integer 
     */
    public function getVotedPointsAfter()
    {
        return $this->voted_points_after;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Vote
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Vote
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}