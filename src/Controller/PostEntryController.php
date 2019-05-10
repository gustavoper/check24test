<?php

namespace App\Controller;


use Doctrine\ORM\NoResultException;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PostEntryController extends AbstractController
{
    /**
     *
     * Show a blog post (Entry)
     *
     * @Route("/post/{id}", name="show_post", requirements={"id"="\d+"})
     */
    public function index(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $postEntry = $em->getRepository('App:PostEntry')->find($id);
        if (empty($postEntry)) {
            throw new $this->createNotFoundException("Post Not Found");
        }
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostEntryController',
            'postEntry'       => $postEntry
        ]);
    }
}
