<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteRepository::class)]
#[ApiResource]
class Site
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $path = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'id_site')]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'site', targetEntity: Page::class)]
    private Collection $pages;

    #[ORM\OneToMany(mappedBy: 'site', targetEntity: DataSet::class)]
    private Collection $dataSets;

    #[ORM\OneToMany(mappedBy: 'site', targetEntity: Theme::class)]
    private Collection $themes;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->pages = new ArrayCollection();
        $this->dataSets = new ArrayCollection();
        $this->themes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNom();
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

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): static
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addIdSite($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeIdSite($this);
        }

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
            $page->setSite($this);
        }

        return $this;
    }

    public function removePage(Page $page): static
    {
        if ($this->pages->removeElement($page)) {
            // set the owning side to null (unless already changed)
            if ($page->getSite() === $this) {
                $page->setSite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DataSet>
     */
    public function getDataSets(): Collection
    {
        return $this->dataSets;
    }

    public function addDataSet(DataSet $dataSet): static
    {
        if (!$this->dataSets->contains($dataSet)) {
            $this->dataSets->add($dataSet);
            $dataSet->setSite($this);
        }

        return $this;
    }

    public function removeDataSet(DataSet $dataSet): static
    {
        if ($this->dataSets->removeElement($dataSet)) {
            // set the owning side to null (unless already changed)
            if ($dataSet->getSite() === $this) {
                $dataSet->setSite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Theme>
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }

    public function addTheme(Theme $theme): static
    {
        if (!$this->themes->contains($theme)) {
            $this->themes->add($theme);
            $theme->setSite($this);
        }

        return $this;
    }

    public function removeTheme(Theme $theme): static
    {
        if ($this->themes->removeElement($theme)) {
            // set the owning side to null (unless already changed)
            if ($theme->getSite() === $this) {
                $theme->setSite(null);
            }
        }

        return $this;
    }
}
