<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @Serializer\ExclusionPolicy("ALL")
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "show_user",
 *          parameters = { "id" = "expr(object.getId())", "clientId" = "expr(object.getClient().id)" }
 *      )
 * )
 * @Hateoas\Relation(
 *      "delete",
 *      href = @Hateoas\Route(
 *          "delete_user",
 *          parameters = { "id" = "expr(object.getId())", "clientId" = "expr(object.getClient().id)" }
 *      )
 * )
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Expose
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Ce champ ne doit pas être null.")
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide.")
     * @Assert\Length(
     *      min = 2,
     *      max = 20,
     *      minMessage = "Le prénom doit comporter au minimum {{ limit }} caractères",
     *      maxMessage = "Le prénom doit comporter au maximum {{ limit }} caractères"
     * )
     * @Serializer\Expose
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Ce champ ne doit pas être null.")
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide.")
     * @Assert\Length(
     *      min = 2,
     *      max = 20,
     *      minMessage = "Le nom doit comporter au minimum {{ limit }} caractères",
     *      maxMessage = "Le nom doit comporter au maximum {{ limit }} caractères"
     * )
     * @Serializer\Expose
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Ce champ ne doit pas être null.")
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide.")
     * @Assert\Email(message="Votre email n'est pas valide.")
     * @Serializer\Expose
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
