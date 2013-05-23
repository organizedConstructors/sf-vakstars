<?php

namespace VAK\StarsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use VAK\StarsBundle\Entity\Vote;
use VAK\StarsBundle\Form\VoteType;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new VoteType());

        $votes = $em->getRepository('VAKStarsBundle:Vote')->createQueryBuilder('v')
            ->orderBy('v.created_at', 'DESC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
        ;

        $users = $em->getRepository('VAKStarsBundle:User')->createQueryBuilder('u')
            ->orderBy('u.score', 'DESC')
            ->getQuery()
            ->getResult()
        ;

        return [
            'form' => $form->createView(),
            'votes' => $votes,
            'users' => $users,
        ];
    }

    /**
     * @Route("/process_vote", name="process_vote")
     * @Method({"POST"})
     */
    public function processVote()
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $vote = new Vote();
        $form = $this->createForm(new VoteType(), $vote);
        $form->bind($request);

        if($form->isValid()) {
            $voted_user = $vote->getVotedUser();
            $voter_user = $vote->getVoterUser();

            $voted_user->addVotesForUser($vote);
            $voter_user->addVotesByUser($vote);

            $vote->setVotedPointsBefore($voted_user->getScore());
            $vote->setVotedPointsAfter($voted_user->getScore()+10);
            $vote->setVoterPointsBefore($voter_user->getScore());
            $vote->setVoterPointsAfter($voter_user->getScore()+1);

            $voted_user->setScore($vote->getVotedPointsAfter());
            $voter_user->setScore($vote->getVoterPointsAfter());

            $em->persist($vote);
            $em->persist($voted_user);
            $em->persist($voter_user);

            $em->flush();

            $this->get('session')->getFlashBag()->add("notice", 'vote_added');
            return $this->redirect($this->generateUrl('home'));
        }

        $this->get('session')->getFlashBag()->add("warning", 'vote_not_added');
        return $this->redirect($this->generateUrl('home'));
    }
}
