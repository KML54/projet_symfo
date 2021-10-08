<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControllerNameController extends AbstractController
{
    /**
     * @Route("/controller/name/{number}")
     */
    public function number(int $number): Response
    {
        //$number = random_int(0,100);

        return $this->render('controller/number.html.twig', [
            'number' => $number,
        ]);
    }
}