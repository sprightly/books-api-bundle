<?php

namespace AppBundle\Controller;

use BooksApiBundle\Api\BooksInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        /** @var BooksInterface $booksApi */
        $booksApi = $this->get('BooksApiBundle.Api.Books');

        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'books' => $booksApi->getBooks()
        ]);
    }
}
