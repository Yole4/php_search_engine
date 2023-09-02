<?php
require_once '../res api/configuration/config.php';
require_once 'vendor/autoload.php';

session_start();
use PhpOffice\PhpWord\IOFactory;

if (isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = $conn->prepare("SELECT getname FROM all_research_data WHERE id = :id");
    $sql->execute(['id' => $id]);
    $sqlCount = $sql->rowCount();

    if ($sqlCount > 0){
        $row = $sql->fetch(PDO::FETCH_ASSOC);
    }
    $docxName = $row['getname'];
    $filename = "../res api/users account/users/unit head/attributes/research documents/". $docxName;
}

// Load the .docx file
$phpWord = IOFactory::load($filename);

// Get the content of the .docx file
$content = '';
$wordCount = 0;
$wordSets = array(); // Array to hold each set of 30 words

foreach ($phpWord->getSections() as $section) {
    foreach ($section->getElements() as $element) {
        // Check the element type
        $elementType = get_class($element);
        switch ($elementType) {
            case 'PhpOffice\PhpWord\Element\Text':
                // For text elements, append the text to the content and count words
                $words = str_word_count($element->getText());
                $wordCount += $words;
                $content .= $element->getText() . ' ';

                // Check if word count exceeds 30
                if ($wordCount >= 30) {
                    // Trim the content to the first 30 words
                    $content = trim(preg_replace('/\s+/', ' ', $content));
                    $wordsArray = explode(' ', $content);
                    $wordSet = implode(' ', array_slice($wordsArray, 0, 30));
                    $wordSets[] = $wordSet;
                    $content = '';
                    $wordCount = 0;
                }
                break;
            case 'PhpOffice\PhpWord\Element\TextRun':
                // For text run elements, append the text of each text run to the content
                foreach ($element->getElements() as $textRunElement) {
                    if ($textRunElement instanceof \PhpOffice\PhpWord\Element\Text) {
                        // Append the text to the content and count words
                        $words = str_word_count($textRunElement->getText());
                        $wordCount += $words;
                        $content .= $textRunElement->getText() . ' ';

                        // Check if word count exceeds 30
                        if ($wordCount >= 30) {
                            // Trim the content to the first 30 words
                            $content = trim(preg_replace('/\s+/', ' ', $content));
                            $wordsArray = explode(' ', $content);
                            $wordSet = implode(' ', array_slice($wordsArray, 0, 30));
                            $wordSets[] = $wordSet;
                            $content = '';
                            $wordCount = 0;
                        }
                    }
                }
                break;
            default:
                // Handle other element types as needed
                break;
        }
    }
}

// Add the remaining words to the wordSets array if any
if (!empty($content)) {
    $content = trim(preg_replace('/\s+/', ' ', $content));
    $wordsArray = explode(' ', $content);
    $wordSet = implode(' ', array_slice($wordsArray, 0, 30));
    $wordSets[] = $wordSet;
}

// Formula
$arrayCount = count($wordSets);
$MyOrig = array();
$MySimilar = array();

// print_r($wordSets);

// $_SESSION['wordset'] = $wordSets;

// header("Location: plagiarismCheck.php");

// for ($i = 0; $i <= 0; $i++){ // $arrayCount should be on position 1 to check all sentence
//     // echo "Word Set ".($i + 1). " = ". $wordSets[$i];

    
        $client = new GuzzleHttp\Client();
            
        $url = "https://plagiarismsearch.com/api/v3/";
        $user = "shelomora13@gmail.com";
        $apiKey = "5zotvshlsbk1h51mqp70ra-166779801";

        // #### RESERVE #######
        // $user = "jrmsuvpred@gmail.com";
        // $apiKey = "unmsim2ijf1u3co9ewf3ph-164340902";

        // #### RESERVE #######
        // $user = "shelomora63@gmail.com";
        // $apiKey = "ew6ookh6pxyqj6q2euoc98-167653932";
            
        // $textToCheck = "Veni, vidi, vici sdjfksdkf";
        $textToCheck = $wordSets[0];
        // $file = "sample.docx";

        createReport();
        // }

        function createReport(){
            global $client, $url, $user, $apiKey, $textToCheck;

            $urls = $url . "reports/create";

            $response = $client->request("POST", $urls,
                [
                    'auth' => [$user, $apiKey],
                    'form_params' => [
                        'text' => $textToCheck,
                        // 'file' => $file,
                    ]
                ]);

            $object = json_decode($response->getBody());

            $reportId = $object->data->id;
            return $reportId;
        } 
        $myId = createReport();
        
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Continue to scan</title>
            <link rel="icon" type="image/x-icon" href="../dist/img/dapitan-log.png">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        </head>
        <body>
        <style>
        /* Button styles */
        .continue-button {
            display: inline-block;
            padding: 10px 20px;
            /* font-size: 18px; */
            text-align: center;
            background-color: darkcyan;
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
            font-size: 18px;
            cursor: pointer;
            
        }
        .container{
            display: flex;
            align-items: center;
            justify-content: center;
            height: 97vh;

        }

        /* Hover effect */
        .continue-button:hover {
            background-color: #f06292;
            transform: scale(1.05);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
    </style>

            <div class="container">
                <form method="POST">
                    <input type="hidden" value="<?php echo $myId ?>" name="reportID">
                    <button class="continue-button" type="submit" name="submitButton" value="getReport">Continue to scan document <i class="fas fa-arrow-right"></i></button>
                </form>
            </div>           
        </body>
        </html>
        <?php
        if ($_POST != null){
            if ($_POST["submitButton"] == "getReport")
            {
                getReport($_POST["reportID"]);
            }}

        // $reportId = createReport();
        // getReport($reportId);

        function getReport($id)
        {
        global $client, $url, $user, $apiKey;

        $url = $url . "reports/" . $id;

        $response = $client->request("POST", $url,
            [
                'auth' => [$user, $apiKey],
            ]);

        $object = json_decode($response->getBody());

        // echo $object;

        // echo $object->data->link;

        $_SESSION['originality'] = $object->data->originality;
        $_SESSION['similar'] = $object->data->similarity;
        header("Location: percentageResult.php");
        }

?>