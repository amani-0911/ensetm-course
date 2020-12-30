<?php

namespace App\Entity;

use App\Repository\DepartementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=DepartementsRepository::class)
 * @Vich\Uploadable
 */
class Departements
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $nom_dep;

    /**
     * @Gedmo\Slug(fields={"nom_dep"})
     * @ORM\Column(length=128,unique=true)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=Filieres::class, mappedBy="departements", orphanRemoval=true)
     */
    private $filieres;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $featured_image;
    /**
     * @Vich\UploadableField(mapping="featured_images",fileNameProperty="featured_image")
     * @var File
     */
    private $imagefile;

    /**
     *  @var \DateTime $Updated_at
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $Updated_at;




    public function __construct()
    {
        $this->filieres = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->nom_dep;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDep(): ?string
    {
        return $this->nom_dep;
    }

    public function setNomDep(string $nom_dep): self
    {
        $this->nom_dep = $nom_dep;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @return Collection|Filieres[]
     */
    public function getFilieres(): Collection
    {
        return $this->filieres;
    }

    public function addFiliere(Filieres $filiere): self
    {
        if (!$this->filieres->contains($filiere)) {
            $this->filieres[] = $filiere;
            $filiere->setDepartements($this);
        }

        return $this;
    }

    public function removeFiliere(Filieres $filiere): self
    {
        if ($this->filieres->removeElement($filiere)) {
            // set the owning side to null (unless already changed)
            if ($filiere->getDepartements() === $this) {
                $filiere->setDepartements(null);
            }
        }

        return $this;
    }

    public function getFeaturedImage()
    {
        return $this->featured_image;
    }

    public function setFeaturedImage($featured_image)
    {
        $this->featured_image = $featured_image;

        return $this;
    }

    public function setImagefile(File $image=null)
    {
        $this->imagefile = $image;
        if ($image){
            $this->Updated_at=new \DateTime('now');
        }
    }

     public function getImagefile()
    {
        return $this->imagefile;
    }




    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->Updated_at;
    }


}
