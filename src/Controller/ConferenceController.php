<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Conference;
use App\Form\CommentFormType;
use App\Message\CommentMessage;
use App\Repository\CommentRepository;
use App\Repository\ConferenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class ConferenceController extends AbstractController
{
    /**
     * @Route("/conferences", name="conferences")
     */
    public function index(Environment $twig, ConferenceRepository $conferenceRepository): Response
    {
        return new Response($twig->render('conference/index.html.twig', [
            'conferences' => $conferenceRepository->findAll(),
        ]));
    }

    /**
     * @Route("/conference/{id}", name="conference")
     */
    public function show(Environment $twig, Conference $conference, CommentRepository $commentRepository)
    {
        return new Response($twig->render('conference/show.html.twig', [
            'conference' => $conference,
            'comments' => $commentRepository->findBy([
                'conference' => $conference], [
                'createdAt' => 'DESC']),
        ]));

    }
}
