<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"api_projects_no_tasks"})
     * @Groups({"api_project_with_tasks"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"api_projects_no_tasks"})
     * @Groups({"api_project_with_tasks"})
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"api_projects_no_tasks"})
     * @Groups({"api_project_with_tasks"})
     */
    private $started_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"api_projects_no_tasks"})
     * @Groups({"api_project_with_tasks"})
     */
    private $ended_at;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"api_projects_no_tasks"})
     * @Groups({"api_project_with_tasks"})
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Task", mappedBy="project", orphanRemoval=true)
     * @Groups({"api_project_with_tasks"})
     */
    private $tasks;


    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeInterface
    {
        return $this->started_at;
    }

    public function setStartedAt(\DateTimeInterface $started_at): self
    {
        $this->started_at = $started_at;

        return $this;
    }

    public function getEndedAt(): ?\DateTimeInterface
    {
        return $this->ended_at;
    }

    public function setEndedAt(?\DateTimeInterface $ended_at): self
    {
        $this->ended_at = $ended_at;

        return $this;
    }

    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

}
