<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=5000)
     */
    private string $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $url;

    /**
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="project")
     */
    private $photos;

    /**
     * @ORM\ManyToMany(targetEntity=Skill::class, mappedBy="projects")
     */
    private $skills;

    /**
     * @ORM\ManyToMany(targetEntity=Customer::class, mappedBy="projects")
     */
    private $customers;

    /**
     * @ORM\ManyToMany(targetEntity=WorkingPartner::class, mappedBy="projects")
     */
    private $workingPartners;


    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->customers = new ArrayCollection();
        $this->workingPartners = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setProject($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getProject() === $this) {
                $photo->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->addProject($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        if ($this->skills->removeElement($skill)) {
            $skill->removeProject($this);
        }

        return $this;
    }

    /**
     * @return Collection|Customer[]
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
            $customer->addProject($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        if ($this->customers->removeElement($customer)) {
            $customer->removeProject($this);
        }

        return $this;
    }

    /**
     * @return Collection|WorkingPartner[]
     */
    public function getWorkingPartners(): Collection
    {
        return $this->workingPartners;
    }

    public function addWorkingPartner(WorkingPartner $workingPartner): self
    {
        if (!$this->workingPartners->contains($workingPartner)) {
            $this->workingPartners[] = $workingPartner;
            $workingPartner->addProject($this);
        }

        return $this;
    }

    public function removeWorkingPartner(WorkingPartner $workingPartner): self
    {
        if ($this->workingPartners->removeElement($workingPartner)) {
            $workingPartner->removeProject($this);
        }

        return $this;
    }
}
