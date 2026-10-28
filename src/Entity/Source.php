<?php

namespace App\Entity;

class Source
{
    private ?int $id = null;
    private string $recap;
    private string $description;
    private string $url;
    private ?int $like = 0;
    private \DateTimeImmutable $createAt;

    //function construct
    public function __construct(
        string $recap,
        string $description,
        string $url
    ){
        $this->recap = $recap;
        $this->description = $description;
        $this->url = $url;
        $this->createAt = new \DateTimeImmutable();
    }

    //getter et setter

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getRecap(): string
    {
        return $this->recap;
    }

    public function setRecap(string $recap): void
    {
        $this->recap = $recap;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getLike(): ?int
    {
        return $this->like;
    }

    public function setLike(?int $like): void
    {
        $this->like = $like;
    }


    public function getCreateAt(): \DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): void
    {
        $this->createAt = $createAt;
    }


    //function pour hydrater

    public static function hydrate(array $source): Source
    {
        //creation de l'objet source
        $newSource = new source(
            $source["recap"],
            $source["description"],
            $source["url"],
        );

        //set des attribut restant
        $newSource->setId($source["id_source"] ?? null);
        $newSource->setCreateAt(new \DateTimeImmutable($source["created_at"] ?? "") ?? null);
        $newSource->setLike($source["like"] ?? null);

        //retourne l'objet source
        return $newSource;

    }
}