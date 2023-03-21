<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
#[ApiResource]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $difficulty = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'skills')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'skill', targetEntity: SubSkill::class)]
    private Collection $subSkills;

    public function __construct()
    {
        $this->subSkills = new ArrayCollection();
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

    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    public function setDifficulty(?int $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, SubSkill>
     */
    public function getSubSkills(): Collection
    {
        return $this->subSkills;
    }

    public function addSubSkill(SubSkill $subSkill): self
    {
        if (!$this->subSkills->contains($subSkill)) {
            $this->subSkills->add($subSkill);
            $subSkill->setSkill($this);
        }

        return $this;
    }

    public function removeSubSkill(SubSkill $subSkill): self
    {
        if ($this->subSkills->removeElement($subSkill)) {
            // set the owning side to null (unless already changed)
            if ($subSkill->getSkill() === $this) {
                $subSkill->setSkill(null);
            }
        }

        return $this;
    }


}
