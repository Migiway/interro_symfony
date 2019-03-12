<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OfferRepository")
 */
class Offer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contract", inversedBy="offers")
     */
    private $contract_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Job", inversedBy="offers")
     */
    private $job_id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Skill", inversedBy="offers")
     */
    private $skill_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Candidature", mappedBy="offer")
     */
    private $candidatures;

    public function __construct()
    {
        $this->skill_id = new ArrayCollection();
        $this->candidatures = new ArrayCollection();
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

    public function getContractId(): ?Contract
    {
        return $this->contract_id;
    }

    public function setContractId(?Contract $contract_id): self
    {
        $this->contract_id = $contract_id;

        return $this;
    }

    public function getJobId(): ?Job
    {
        return $this->job_id;
    }

    public function setJobId(?Job $job_id): self
    {
        $this->job_id = $job_id;

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSkillId(): Collection
    {
        return $this->skill_id;
    }

    public function addSkillId(Skill $skillId): self
    {
        if (!$this->skill_id->contains($skillId)) {
            $this->skill_id[] = $skillId;
        }

        return $this;
    }

    public function removeSkillId(Skill $skillId): self
    {
        if ($this->skill_id->contains($skillId)) {
            $this->skill_id->removeElement($skillId);
        }

        return $this;
    }

    /**
     * @return Collection|Candidature[]
     */
    public function getCandidatures(): Collection
    {
        return $this->candidatures;
    }

    public function addCandidature(Candidature $candidature): self
    {
        if (!$this->candidatures->contains($candidature)) {
            $this->candidatures[] = $candidature;
            $candidature->setOffer($this);
        }

        return $this;
    }

    public function removeCandidature(Candidature $candidature): self
    {
        if ($this->candidatures->contains($candidature)) {
            $this->candidatures->removeElement($candidature);
            // set the owning side to null (unless already changed)
            if ($candidature->getOffer() === $this) {
                $candidature->setOffer(null);
            }
        }

        return $this;
    }
}
