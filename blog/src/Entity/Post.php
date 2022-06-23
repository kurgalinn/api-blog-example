<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PostRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    collectionOperations: [
        "get",
        "post" => ["security" => "is_granted('ROLE_OWNER') or is_granted('ROLE_ADMIN')"],
    ],
    itemOperations: [
        "get",
        "put" => [
            "security" => "is_granted('ROLE_ADMIN') or object.owner == user",
            "security_message" => "Only owner can edit own post.",
        ],
        "delete" => [
            "security" => "is_granted('ROLE_ADMIN') or object.owner == user",
            "security_message" => "Only owner can delete own post.",
        ],
    ],
    paginationItemsPerPage: 10
)]
#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\Table(name: "blog_posts")]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'text', length: 65535)]
    private string $description;

    #[ORM\Column(type: 'datetime_immutable', nullable: false)]
    private DateTimeImmutable $dateFrom;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private DateTimeImmutable $dateTo;

    #[ORM\ManyToOne(targetEntity: Owner::class)]
    #[ORM\JoinColumn(name: 'owner_id', referencedColumnName: 'id', nullable: false)]
    private Owner $owner;

    public function __construct(string $title, string $description, Owner $owner, DateTimeImmutable $dateFrom = null)
    {
        $this->dateFrom = $dateFrom ?? new DateTimeImmutable();
        $this->title = $title;
        $this->description = $description;
        $this->owner = $owner;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOwner(): Owner
    {
        return $this->owner;
    }

    public function setOwner(Owner $owner): void
    {
        $this->owner = $owner;
    }
}
