<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageRepository::class)]
#[ApiResource]
class Page
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\ManyToMany(targetEntity: Bloc::class, inversedBy: 'pages')]
    private Collection $bloc;

    #[ORM\ManyToMany(targetEntity: Article::class, inversedBy: 'pages')]
    private Collection $article;

    #[ORM\ManyToOne(inversedBy: 'pages')]
    private ?Site $site = null;

    public function __construct()
    {
        $this->bloc = new ArrayCollection();
        $this->article = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Bloc>
     */
    public function getBloc(): Collection
    {
        return $this->bloc;
    }

    public function addBloc(Bloc $bloc): static
    {
        if (!$this->bloc->contains($bloc)) {
            $this->bloc->add($bloc);
        }

        return $this;
    }

    public function removeBloc(Bloc $bloc): static
    {
        $this->bloc->removeElement($bloc);

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Article $article): static
    {
        if (!$this->article->contains($article)) {
            $this->article->add($article);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        $this->article->removeElement($article);

        return $this;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): static
    {
        $this->site = $site;

        return $this;
    }
}
