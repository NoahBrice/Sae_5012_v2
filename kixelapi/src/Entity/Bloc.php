<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BlocRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Metadata\ApiProperty;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: BlocRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['bloc:read']],
    denormalizationContext: ['groups' => ['bloc:write']],
    // types: ['https://schema.org/Book'],
    operations: [
        new GetCollection(),
        new Post(inputFormats: ['multipart' => ['multipart/form-data']])
    ]
)]
class Bloc
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contenu = null;

    #[ORM\Column(nullable: true)]
    private ?bool $notable = null;
    ////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////
    //                          Vich                          //
    ////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////


    #[ApiProperty] //(types: ['https://schema.org/contentUrl'])
    #[Groups(['bloc:read'])]
    public ?string $contentUrl = null;


    #[Vich\UploadableField(mapping: 'media_bloc', fileNameProperty: 'filePath')]
    #[Groups(['bloc:write'])]
    public ?File $file = null;

    #[ORM\Column(nullable: true)]
    public ?string $filePath = null;


    ////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////
    //                          Vich Fin                      //
    ////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////   

    #[ORM\ManyToMany(targetEntity: Page::class, mappedBy: 'bloc')]
    private Collection $pages;

    #[ORM\ManyToOne(inversedBy: 'blocs')]
    private ?TypeBloc $TypeBloc = null;

    #[ORM\ManyToMany(targetEntity: Article::class, inversedBy: 'blocs')]
    private Collection $article;

    #[ORM\OneToMany(mappedBy: 'bloc', targetEntity: Commentaire::class)]
    private Collection $commentaires;

    #[ORM\OneToMany(mappedBy: 'bloc', targetEntity: Reaction::class)]
    private Collection $reactions;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

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

    public function getContentUrl(): ?string
    {
        return $this->contentUrl;
    }

    public function setContentUrl(?string $contentUrl): self
    {
        $this->contentUrl = $contentUrl;
        return $this;
    }

    // public function getFile(): ?string
    // {
    //     return $this->file;
    // }

    // public function setFile(?string $file): self
    // {
    //     $this->file = $file;
    //     return $this;
    // }

    public function setFile(?File $file = null): void
    {
        $this->file = $file;

        if (null !== $file) {
            // It is required that at least one field changes if you are using Doctrine,
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): self
    {
        $this->filePath = $filePath;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
