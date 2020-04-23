<?php

namespace App\Controller;

use App\Entity\Manager;
use App\Entity\Project;
use App\Form\ProjectFormType;
use App\Form\ProjectStatusFormType;
use App\Repository\ProjectRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function homePageRedirect()
    {
        return $this->redirectToRoute('project');
    }
    /**
     * @Route("/project", name="project")
     */
    public function projectListing(ProjectRepository $projectRepository, EntityManagerInterface $entityManager)
    {
        // if newly connected = > set the last login time
        if ($this->getUser() && $this->getUser() instanceof Manager){
            $this->getUser()->setLastLogin(new DateTime());
            $entityManager->flush();
        }
        $projects = $projectRepository->findAll();
        return $this->render('project/list.html.twig', [
            'projects' => $projects
        ]);
    }

    /**
     * @Route("/project/add", name="project_add")
     */
    public function addProject(Request $request, EntityManagerInterface $entityManager)
    {
        $newProject = new Project();
        $projetForm = $this->createForm(ProjectFormType::class, $newProject); 

        $projetForm->handleRequest($request);
        if ($projetForm->isSubmitted() && $projetForm->isValid()) {
            // Complete object project
            $newProject->setStartedAt(new DateTime());
            $newProject->setStatus("new");
            // Store the object in database
            $entityManager->persist($newProject);
            $entityManager->flush();
            // To redirect or others
            return $this->redirectToRoute('project');
        }
        return $this->render('project/add.html.twig', [
            'projetForm' => $projetForm->createView()
        ]);
    }

    /**
     * @Route("/project/action/{projectId}", name="project_action")
     */
    public function actionPage(int $projectId, ProjectRepository $projectRepository, Request $request, EntityManagerInterface $entityManager)
    {
        // find the project by the id 
        $currentProject = $projectRepository->find($projectId);
        // Edit the status form
        $editForm = $this->createForm(ProjectStatusFormType::class, $currentProject); 
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if ($currentProject->getStatus() == 'done'){
                $currentProject->setEndedAt(new DateTime());
            }
            $entityManager->flush();
            return $this->redirectToRoute('project_action', ['projectId' => $projectId]);
        }
        return $this->render('project/action.html.twig', [
            'project' => $currentProject,
            'editForm' => $editForm->createView()
        ]);
    }
}






