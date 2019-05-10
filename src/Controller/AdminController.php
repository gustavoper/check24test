<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{

    /**
     * @var \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface
     */
    protected $passwordEncoder;

    /**
     * AdminController constructor.
     * Adding passwordEncoder to ensure password check
     *
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Render admin login
     */
    public function index(Request $request)
    {
        $form = $this->getGeneratedForm();
        $form->handleRequest($request);
        $errorMessage = "";
        if ($form->isSubmitted() && $form->isValid()) {
            //if valid, render the main admin page
            $userInput = $form->getData();
            if ($this->checkUserExists($userInput)) {
                return $this->home();
            }
            $errorMessage = "User not found or invalid password";
        }
        return $this->render('admin/login.html.twig', [
            'controller_name' => 'AdminController',
            'form'            =>  $form->createView(),
            'errorMessage'    =>  $errorMessage
        ]);
    }

    /**
     *
     * Admin homepage
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * Create a new blog post from admin
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createPost()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }


    /**
     * Check if the desired user exists in our database
     *
     * @param array $userDetails
     *
     * @return bool
     */
    private function checkUserExists(array $userDetails) : bool
    {
        $em = $this->getDoctrine()->getManager();

        //checking if its a valid password
        //to prevent malicious attacks
        $validPassword = $this->passwordEncoder->isPasswordValid(
            "User",
            $userDetails['password']
        );
        if (!$validPassword) {
            return false;
        }

        $encodedPassword = $this->passwordEncoder->encodePassword(
            User, $userDetails["password"]
        );

        $foundUser = $em->getRepository('App:User')->findOneBy(
            [
                "username" => $userDetails["username"],
                "password" => $encodedPassword
            ]
        );
        if (empty($foundUser)) {
            return false;
        }
        return true;
    }


    /**
     * Returns the default form
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function getGeneratedForm()
    {
        //Creating the login form
        $form = $this->createFormBuilder()
            ->add('username',TextType::class,
                [
                    "required" => true
                ]
            )
            ->add('password', PasswordType::class,
                [
                    "required" => true
                ]
            )
            ->add('save', SubmitType::class, ['label' => 'Login!'])
            ->getForm();
        return $form;
    }
}
