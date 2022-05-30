<?php
namespace Lab4;

require_once 'AdsRepositoryInterface.php';

class AdsBoard
{
    const TEMPLATE_PATH = __DIR__ . '/Template/AdsBoardTemplate.html';

    private string $formHandlerPath;
    private AdsRepositoryInterface $adsRepository;

    public function __construct(string $formHandlerPath, AdsRepositoryInterface $adsRepository)
    {
        $this->adsRepository = $adsRepository;
        $this->formHandlerPath = $formHandlerPath;
    }

    public function handleRequest(): void
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->render();
                break;
            case 'POST':
                $this->addAdvertisement();
                break;
            default:
                http_response_code(405);
                echo 'Method Not Allowed';
        }
    }

    private function render(): void
    {
        $html = file_get_contents(self::TEMPLATE_PATH);
        $categoriesListHtml = $adsTableHtml = '';

        foreach (Advertisement::CATEGORIES as $category) {
            $categoriesListHtml .= "<option value=\"$category\">$category</option>";

            foreach ($this->adsRepository->getAds($category) as $ad) {
                $description = nl2br($ad->getDescription());
                $adsTableHtml .= "
                <tr>
                    <td>{$ad->getCategory()}</td>
                    <td>{$ad->getTitle()}</td>
                    <td>$description</td>
                    <td>{$ad->getEmail()}</td>
                </tr>
            ";
            }
        }

        echo str_replace(
            ["{{ ACTION }}", "{{ CATEGORIES }}", "{{ ADVERTISEMENTS }}"],
            [$this->formHandlerPath, $categoriesListHtml, $adsTableHtml],
            $html
        );
    }

    private function addAdvertisement(): void
    {
        if (!isset($_POST["email"], $_POST["category"], $_POST["title"], $_POST["description"])) {
            http_response_code(400);
            echo "Bad Request";
            return;
        }

        $ad = new Advertisement($_POST["category"], $_POST["title"], $_POST["description"], $_POST["email"]);

        if ($this->adsRepository->append($ad)) {
            header("Refresh:0");
        } else {
            http_response_code(500);
            echo "Internal Server Error";
        }
    }
}