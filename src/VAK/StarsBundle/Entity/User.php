<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nezuvian
 * Date: 2013.05.13.
 * Time: 23:43
 * To change this template use File | Settings | File Templates.
 */

namespace VAK\StarsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="Vote", mappedBy="voter_user")
     */
    protected $votes_by_user;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="Vote", mappedBy="voted_user")
     */
    protected $votes_for_user;

    /**
     * @var
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $score;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    protected $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    protected $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="facebookId", type="string", length=255, nullable=true)
     */
    protected $facebookId;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updated_at;



    public function serialize()
    {
        return serialize(array($this->facebookId, parent::serialize()));
    }

    public function unserialize($data)
    {
        list($this->facebookId, $parentData) = unserialize($data);
        parent::unserialize($parentData);
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get the full name of the user (first + last name)
     * @return string
     */
    public function getFullName()
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }

    /**
     * @param string $facebookId
     * @return void
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
        $this->setUsername($facebookId);
    }

    /**
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @param Array
     */
    public function setFBData($fbdata)
    {
        if (isset($fbdata['id'])) {
            $this->setFacebookId($fbdata['id']);
            $this->addRole('ROLE_FACEBOOK');
        }
        if (isset($fbdata['first_name'])) {
            $this->setFirstname($fbdata['first_name']);
        }
        if (isset($fbdata['last_name'])) {
            $this->setLastname($fbdata['last_name']);
        }
        if (isset($fbdata['email'])) {
            $this->setEmail($fbdata['email']);
        }
    }

    public function __construct()
    {
        parent::__construct();
        $this->votes_by_user = new ArrayCollection();
        $this->votes_for_user = new ArrayCollection();
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
     * Add votes_by_user
     *
     * @param \VAK\StarsBundle\Entity\Vote $votesByUser
     * @return User
     */
    public function addVotesByUser(\VAK\StarsBundle\Entity\Vote $votesByUser)
    {
        $this->votes_by_user[] = $votesByUser;
    
        return $this;
    }

    /**
     * Remove votes_by_user
     *
     * @param \VAK\StarsBundle\Entity\Vote $votesByUser
     */
    public function removeVotesByUser(\VAK\StarsBundle\Entity\Vote $votesByUser)
    {
        $this->votes_by_user->removeElement($votesByUser);
    }

    /**
     * Get votes_by_user
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVotesByUser()
    {
        return $this->votes_by_user;
    }

    /**
     * Add votes_for_user
     *
     * @param \VAK\StarsBundle\Entity\Vote $votesForUser
     * @return User
     */
    public function addVotesForUser(\VAK\StarsBundle\Entity\Vote $votesForUser)
    {
        $this->votes_for_user[] = $votesForUser;
    
        return $this;
    }

    /**
     * Remove votes_for_user
     *
     * @param \VAK\StarsBundle\Entity\Vote $votesForUser
     */
    public function removeVotesForUser(\VAK\StarsBundle\Entity\Vote $votesForUser)
    {
        $this->votes_for_user->removeElement($votesForUser);
    }

    /**
     * Get votes_for_user
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVotesForUser()
    {
        return $this->votes_for_user;
    }

    /**
     * Set score
     *
     * @param integer $score
     * @return User
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer
     * @todo negatív szavazatokra kibővíteni
     */
    public function getScore()
    {
        if($this->getVotesForUser() === null) {
            return 0;
        } else {
            $votes = $this->getVotesForUser();
            $score = 0;
            foreach($votes as $vote) {
                $score+=10;
            }

            $votes = $this->getVotesByUser();
            foreach($votes as $vote) {
                $score+=2;
            }

            return $score;
        }
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}
