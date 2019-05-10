<?php

namespace App\Controller;

use Doctrine\ORM\NoResultException;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * The index route shows all blog entries for now
     *
     * @Route("/blog", name="blog")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('App:PostEntry')->findAll();
        if (empty($posts)) {
            throw $this->createNotFoundException("No blog posts");
        }
        return $this->render('blog/index.html.twig', [
                'controller_name' => 'BlogController',
                "posts" => $posts
            ]
        );

    }

}
