<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskFormType;
use App\Repository\ProjectRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * @Route("/task/add/{projectId}", name="task_add")
     */
    public function addTask(Request $request, EntityManagerInterface $entityManager, int $projectId, ProjectRepository $projectRepository)
    {
        $currentProject = $projectRepository->find($projectId);
        $newTask = new Task();
        $newTask->setProject($currentProject);
        $taskForm = $this->createForm(TaskFormType::class, $newTask); 

        $taskForm->handleRequest($request);
        if ($taskForm->isSubmitted() && $taskForm->isValid()) {
            // Complete object project
            $newTask->setCreatedAt(new DateTime());
            // Store the object in database
            $entityManager->persist($newTask);
            $entityManager->flush();
            // To redirect back to project action page
            return $this->redirectToRoute('project_action', ['projectId' => $projectId]);
        }
        return $this->render('task/add.html.twig', [
            'taskForm' => $taskForm->createView(),
            'currentProject' => $currentProject
        ]);

    }
}
