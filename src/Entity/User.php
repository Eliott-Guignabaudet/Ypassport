<?php

namespace App\Entity;

use ApiPlatform\Action\NotFoundAction;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use App\Controller\MeController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

use Normalizer;
use PhpParser\Builder\Method;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    security: 'is_granted("ROLE_USER")',
    operations: [
        
        new Get(
            controller : NotFoundAction::class,
            read : false,
            output : false,
            openapiContext: [
                'summary' => 'hidden',
            ],
        ),
        new GetCollection(
            uriTemplate: '/me',
            controller: MeController::class,
            status: 200,
            read: false,
            paginationEnabled: false,
            
            openapiContext: [
                'security' => ['cookieAuth' => []],
            ],
        )
        
    ],
    normalizationContext: [
        'groups' => ['user:read'],
    ],



    // collectionOperations: [
    //     'me' =>[
    //         'pagination_enabled' => false,
    //         'path' => '/me',
    //         'method' => 'get',
    //         'controller' => MeController::class,
    //         'read' => false,
    //     ],
    // ],
    // itemOperations: [
    //     'get' => [
    //         'controller' => NotFoundAction::class,
    //         'openapi_context' => [
    //             'summary' => 'hidden',
    //         ],
    //         'read' => false,
    //         'output' => false,
    //     ],
    // ],
    
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['user:read'])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    private ?string $firstName = null;

    #[ORM\Column(length: 100)]
    private ?string $lastName = null;

    #[ORM\Column(length: 100)]
    private ?string $type = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $year = null;


    #[ORM\ManyToMany(targetEntity: SubSkill::class, inversedBy: 'users')]
    private Collection $subSkill;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Branch $branch = null;

    public function __construct()
    {
        $this->subSkill = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(?string $year): self
    {
        $this->year = $year;

        return $this;
    }



    /**
     * @return Collection<int, SubSkill>
     */
    public function getSubSkill(): Collection
    {
        return $this->subSkill;
    }

    public function addSubSkill(SubSkill $subSkill): self
    {
        if (!$this->subSkill->contains($subSkill)) {
            $this->subSkill->add($subSkill);
        }

        return $this;
    }

    public function removeSubSkill(SubSkill $subSkill): self
    {
        $this->subSkill->removeElement($subSkill);

        return $this;
    }

    public function getBranch(): ?Branch
    {
        return $this->branch;
    }

    public function setBranch(?Branch $branch): self
    {
        $this->branch = $branch;

        return $this;
    }
}
