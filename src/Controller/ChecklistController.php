<?php

namespace MorgenBord\ChecklistWidgetBundle\Controller;

use App\Entity\UserWidget;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WidgetApiController extends AbstractController
{
    #[Route('/api/data/{id}', name: 'api_data_set', methods: ['PUT', 'PATCH'])]
    public function setData(EntityManagerInterface $em, RequestStack $request, UserWidget $userWidget): Response
    {
        $data = json_decode($request->getCurrentRequest()->getContent(), true);
        $userWidget->setData($data);

        return $this->json($userWidget, 200, [], ['groups' => ['widget']]);
    }

    #[Route('/api/data/{id}', name: 'api_data_get', methods: ['GET'])]
    public function getData(UserWidget $userWidget): Response
    {
        return $this->json($userWidget->getData());
    }
}
