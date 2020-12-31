<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Validator\Constraints as Assert;

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
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="customers")
     */
    private $company;

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
