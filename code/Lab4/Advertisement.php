<?php
namespace Lab4;

class Advertisement
{
    const PETS_CATEGORY = 'Pets',
          KIDS_CATEGORY = 'Kids',
          WOMEN_CATEGORY = 'Women',
          MEN_CATEGORY = 'Men';

    const CATEGORIES = [
        self::PETS_CATEGORY,
        self::KIDS_CATEGORY,
        self::WOMEN_CATEGORY,
        self::MEN_CATEGORY,
    ];

    private string $category;
    private string $title;
    private string $description;
    private string $email;

    public function __construct(string $category, string $title, string $description, string $email)
    {
        $this->category = $category;
        $this->title = $title;
        $this->description = $description;
        $this->email = $email;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}