<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;


#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['bloc_object:read']],
    types: ['https://schema.org/MediaObject'])]
    #[Get(security: "is_granted('ROLE_AUTHEUR')")]
    #[GetCollection(security: "is_granted('ROLE_AUTHEUR')")]
    #[Put(security: "is_granted('ROLE_AUTHEUR')")]
    #[Delete(security: "is_granted('ROLE_AUTHEUR')")]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['bloc_object:read'])]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['bloc_object:read'])]
    private ?string $resume = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['bloc_object:read'])]
    private ?int $position = null;

    #[ORM\ManyToMany(targetEntity: Page::class, mappedBy: 'article')]
    #[Groups(['bloc_object:read'])]
    private Collection $pages;

    #[ORM\ManyToMany(targetEntity: Bloc::class, mappedBy: 'article')]
    #[Groups(['bloc_object:read'])]
    private Collection $blocs;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
        $this->blocs = new ArrayCollection();
    }

    
    public function __toString()
    {
        return $this->getTitre();
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(?string $resume): static
    {
        $this->resume = $resume;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): static
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Collection<int, Page>
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(Page $page): static
    {
        if (!$this->pages->contains($page)) {
            $this->pages->add($page);
            $page->addArticle($this);
        }

        return $this;
    }

    public function removePage(Page $page): static
    {
        if ($this->pages->removeElement($page)) {
            $page->removeArticle($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Bloc>
     */
    public function getBlocs(): Collection
    {
        return $this->blocs;
    }

    public function addBloc(Bloc $bloc): static
    {
        if (!$this->blocs->contains($bloc)) {
            $this->blocs->add($bloc);
            $bloc->addArticle($this);
        }

        return $this;
    }

    public function removeBloc(Bloc $bloc): static
    {
        if ($this->blocs->removeElement($bloc)) {
            $bloc->removeArticle($this);
        }

        return $this;
    }
}
