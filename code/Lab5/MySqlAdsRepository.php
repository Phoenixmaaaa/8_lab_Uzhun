<?php
namespace Lab5;

use Lab4\Advertisement;

require_once '../Lab4/AdsRepositoryInterface.php';

class MySqlAdsRepository implements \Lab4\AdsRepositoryInterface
{
    private \mysqli $db;

    public function __construct()
    {
        $this->db = new \mysqli('db', 'root', 'helloworld', 'web');
    }

    public function getAds(string $category): array
    {
        $query = "SELECT * FROM advertisement WHERE category = '$category'";

        if (!mysqli_connect_error() && $result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $ads[] = new Advertisement(
                    $row["category"],
                    $row["title"],
                    $row["description"],
                    $row["email"]
                );
            }
        }

        return $ads ?? [];
    }

    public function append(\Lab4\Advertisement $advertisement): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO advertisement (category, title, description, email) values (?, ?, ?, ?)"
        );

        $category = $advertisement->getCategory();
        $title = $advertisement->getTitle();
        $description = $advertisement->getDescription();
        $email = $advertisement->getEmail();

        return $stmt->bind_param("ssss", $category, $title, $description, $email)
            && $stmt->execute()
            && $stmt->close();
    }
}