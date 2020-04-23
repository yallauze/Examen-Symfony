<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/project", name="api_get_projects", methods={"GET"})
     */
    public function getAllProjects(ProjectRepository $projectRepository)
    {
        $projects = $projectRepository->findAll();
        if (count($projects) === 0){
            return $this->json(['message' => 'No projects yet in our database!!'], 200);
        }
        return $this->json($projects, 200, [], ['groups' => ['api_projects_no_tasks']]);
    }

    /**
     * @Route("/api/project/{projectId}", name="api_get_project_by_id", methods={"GET"})
     */
    public function getOneProjectById(ProjectRepository $projectRepository, int $projectId)
    {
        $project = $projectRepository->find($projectId);
        if (!$project) {
            return $this->json(['message' => 'No project found for id '.$projectId], 200);
        }
        return $this->json($project, 200, [], ['groups' => ['api_project_with_tasks']]);
    }

}
