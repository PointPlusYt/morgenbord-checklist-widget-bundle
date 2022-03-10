<?php

namespace MorgenBord\ChecklistWidgetBundle\Controller;

use MorgenBord\CoreBundle\Entity\UserWidget;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/checklist', name: 'checklist_bundle_')]
class ChecklistController extends AbstractController
{
    #[Route('/{id}', name: 'show_public')]
    public function showPublic(UserWidget $userWidget): Response
    {
        // TODO : Add a way to make some checklists public and protect others
        // TODO : Check if widget is really a checklist
        return $this->render('@ChecklistWidget/public.html.twig', [
            'userWidget' => $userWidget,
        ]);
    }
}
