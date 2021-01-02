<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 * @Serializer\ExclusionPolicy("ALL")
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "api_show_customer",
 *          parameters = { "id" = "expr(object.getId())", "companyId" = "expr(object.getCompany().id)" }
 *      )
 * )
 * @Hateoas\Relation(
 *      "delete",
 *      href = @Hateoas\Route(
 *          "api_delete_customer",
 *          parameters = { "id" = "expr(object.getId())", "companyId" = "expr(object.getCompany().id)" }
 *      )
 * )
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Expose
     * @OA\Property(description="The unique identifier of the customer.")
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
     * @OA\Property(type="string", maxLength=255)
     */
    private $firstname;

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
     * @OA\Property(type="string", maxLength=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Ce champ ne doit pas être null.")
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide.")
     * @Assert\Email(message="Veuillez insérer un email valide")
     * @Serializer\Expose
     * @OA\Property(type="string", maxLength=255)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="customers")
     */
    private $company;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }
}
