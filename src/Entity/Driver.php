<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DriverRepository")
 */
class Driver
{
    const SERVER_PATH_TO_IMAGE_FOLDER = 'uploads/driver';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     * @Assert\Length(
     *      min = 2,
     *      max = 45,
     *      minMessage = "ФИО должно быть хотя бы из {{ limit }} символа",
     *      maxMessage = "ФИО должно быть не более {{ limit }} символов"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="date")
     */
    private $birth_date;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Email(
     *     message = "Email '{{ value }}' не валидный",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=40)
     * @Assert\Length(
     *      min = 2,
     *      max = 45,
     *      minMessage = "Телефон должен быть хотя бы из {{ limit }} символа",
     *      maxMessage = "Телефон должен быть не более {{ limit }} символов"
     * )
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $avatar;

    private $image;


    /**
     * @return UploadedFile
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }


    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;
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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Vehicle", inversedBy="drivers")
     */
    private $vehicle;

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

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birth_date;
    }

    public function setBirthDate(\DateTimeInterface $birth_date): self
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }



    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): self
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function __toString()
    {
        return $this->name ?: '';
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
            "driver".$date->getTimestamp().$type
        );


        $this->setAvatar("driver".$date->getTimestamp().$type);

    }

    public function delete()
    {
        $fileSystem = new Filesystem();
        $fileSystem->remove(self::SERVER_PATH_TO_IMAGE_FOLDER.'/'.$this->getAvatar());
    }

    public function lifecycleFileUpload()
    {
        $this->upload();
    }

    public function lifecycleFileDelete()
    {
        if ($this->getAvatar()){
            $this->delete();
        }
    }

}
