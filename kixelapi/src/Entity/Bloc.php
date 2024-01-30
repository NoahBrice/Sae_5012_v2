<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BlocRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BlocRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['bloc_object:read']],
    types: ['https://schema.org/MediaObject'])]
class Bloc
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
    private ?string $contenu = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['bloc_object:read'])]
    private ?bool $notable = null;

    #[ORM\ManyToMany(targetEntity: Page::class, mappedBy: 'bloc')]
    // #[Groups(['bloc_object:read'])]
    private Collection $pages;

    #[ORM\ManyToOne(inversedBy: 'blocs')]
    #[Groups(['bloc_object:read'])]
    private ?TypeBloc $TypeBloc = null;

    #[ORM\ManyToMany(targetEntity: Article::class, inversedBy: 'blocs')]
    // #[Groups(['bloc_object:read'])]
    private Collection $article;

    #[ORM\OneToMany(mappedBy: 'bloc', targetEntity: Commentaire::class)]
    #[Groups(['bloc_object:read'])]
    private Collection $commentaires;

    #[ORM\OneToMany(mappedBy: 'bloc', targetEntity: Reaction::class)]
    #[Groups(['bloc_object:read'])]
    private Collection $reactions;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
        $this->article = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->reactions = new ArrayCollection();
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

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function isNotable(): ?bool
    {
        return $this->notable;
    }

    public function setNotable(?bool $notable): static
    {
        $this->notable = $notable;

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
            $page->addBloc($this);
        }

        return $this;
    }

    public function removePage(Page $page): static
    {
        if ($this->pages->removeElement($page)) {
            $page->removeBloc($this);
        }

        return $this;
    }

    public function getTypeBloc(): ?TypeBloc
    {
        return $this->TypeBloc;
    }

    public function setTypeBloc(?TypeBloc $TypeBloc): static
    {
        $this->TypeBloc = $TypeBloc;

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

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setBloc($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getBloc() === $this) {
                $commentaire->setBloc(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reaction>
     */
    public function getReactions(): Collection
    {
        return $this->reactions;
    }

    public function addReaction(Reaction $reaction): static
    {
        if (!$this->reactions->contains($reaction)) {
            $this->reactions->add($reaction);
            $reaction->setBloc($this);
        }

        return $this;
    }

    public function removeReaction(Reaction $reaction): static
    {
        if ($this->reactions->removeElement($reaction)) {
            // set the owning side to null (unless already changed)
            if ($reaction->getBloc() === $this) {
                $reaction->setBloc(null);
            }
        }

        return $this;
    }
}
