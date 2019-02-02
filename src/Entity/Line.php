<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LineRepository")
 */
class Line
{

    const SERVER_PATH_TO_IMAGE_FOLDER = 'uploads/map';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Код должен быть хотя бы из {{ limit }} символа",
     *      maxMessage = "Код должен быть не более {{ limit }} символов"
     * )
     */
    private $code;

    /**
     * @ORM\Column(type="time")
     */
    private $start_time_operation;

    /**
     * @ORM\Column(type="time")
     */
    private $end_time_operation;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Length(
     *      min = 2,
     *      max = 30,
     *      minMessage = "Тип должен быть хотя бы из {{ limit }} символа",
     *      maxMessage = "Тип должен быть не более {{ limit }} символов"
     * )
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $map;

    private $image;


    /**
     * @return UploadedFile
     */
    public function getMap(): ?string
    {
        return $this->map;
    }


    public function setMap($map): self
    {
        $this->map = $map;
        return $this;
    }

    public function getImage(): ?UploadedFile
    {
        return $this->image;
    }

    public function setImage(?UploadedFile $image = null)
    {
        $this->image = $image;
        return $this;
    }

    public function upload()
    {
        if (null === $this->getImage()) {
            return;
        }

        $date = new \DateTime();
        $name = $this->getImage()->getClientOriginalName();

        $type = substr($name, strpos($name, '.'));

        $this->getImage()->move(
            self::SERVER_PATH_TO_IMAGE_FOLDER,
            "map".$date->getTimestamp().$type
        );


        $this->setMap("map".$date->getTimestamp().$type);

    }

    public function delete()
    {
        $fileSystem = new Filesystem();
        $fileSystem->remove(self::SERVER_PATH_TO_IMAGE_FOLDER.'/'.$this->getMap());
    }

    public function lifecycleFileUpload()
    {
        $this->upload();
    }

    public function lifecycleFileDelete()
    {
        if ($this->getMap()){
            $this->delete();
        }
    }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Station", mappedBy="line")
     */
    private $station;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vehicle", mappedBy="line")
     */
    private $vehicles;

    public function __construct()
    {
        $this->station = new ArrayCollection();
        $this->vehicles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getStartTimeOperation(): ?\DateTimeInterface
    {
        return $this->start_time_operation;
    }

    public function setStartTimeOperation(\DateTimeInterface $start_time_operation): self
    {
        $this->start_time_operation = $start_time_operation;

        return $this;
    }

    public function getEndTimeOperation(): ?\DateTimeInterface
    {
        return $this->end_time_operation;
    }

    public function setEndTimeOperation(\DateTimeInterface $end_time_operation): self
    {
        $this->end_time_operation = $end_time_operation;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }



    /**
     * @return Collection|Station[]
     */
    public function getStation(): Collection
    {
        return $this->station;
    }

    public function addStation(Station $station): self
    {
        if (!$this->station->contains($station)) {
            $this->station[] = $station;
            $station->setLine($this);
        }

        return $this;
    }

    public function removeStation(Station $station): self
    {
        if ($this->station->contains($station)) {
            $this->station->removeElement($station);
            // set the owning side to null (unless already changed)
            if ($station->getLine() === $this) {
                $station->setLine(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Vehicle[]
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): self
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles[] = $vehicle;
            $vehicle->setLine($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): self
    {
        if ($this->vehicles->contains($vehicle)) {
            $this->vehicles->removeElement($vehicle);
            // set the owning side to null (unless already changed)
            if ($vehicle->getLine() === $this) {
                $vehicle->setLine(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->code ?: '';
    }


    public function render()
    {
        $result = ['path' => self::SERVER_PATH_TO_IMAGE_FOLDER.'/'.$this->map,
            'entity' => 'line'];
        $this->map = null;
        return $result;
    }
}
