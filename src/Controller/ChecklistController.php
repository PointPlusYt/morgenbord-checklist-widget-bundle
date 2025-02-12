<?php

namespace Morgenbord\ChecklistWidgetBundle\Controller;

use Morgenbord\CoreBundle\Entity\UserWidget;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/checklist', name: 'checklist_bundle_')]
class ChecklistController extends AbstractController
{
    #[Route('/{id}', name: 'show_public')]
    public function showPublic(UserWidget $userWidget): Response
    {
        return $this->render('@ChecklistWidget/public.html.twig', [
            'userWidget' => $userWidget,
        ]);
    }
}
