<?php
    ini_set('max_execution_time', 1800);

    session_start();

    require_once '../res api/configuration/config.php';
    require_once 'vendor/autoload.php';

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
    
    // $filename = "../proposal.docx";

    $filename = "../res api/users account/users/unit head/attributes/research documents/sample.docx";

    // Load the document
    $phpWord = IOFactory::load($filename);


    // Iterate over the sections and paragraphs of the document
    $content = '';
    $section = $phpWord->getSections()[0];
    foreach ($section->getElements() as $element) {
        if ($element instanceof \PhpOffice\PhpWord\Element\Text) {
            $content .= $element->getText();
        } elseif ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
            foreach ($element->getElements() as $textElement) {
                if ($textElement instanceof \PhpOffice\PhpWord\Element\Text) {
                    $content .= $textElement->getText();
                }
            }
        }
    }

    $arraySentence = explode(".", $content);
    for ($x = 0; $x < count($arraySentence); $x++)
    {
        if ($arraySentence[$x] == "" || $arraySentence[$x] == " ")
        {
            unset($arraySentence[$x]);
        }
    }

    // Remove empty values from the array
    $another = array_filter($arraySentence);

    foreach( $another as $index => $fruit){
        // echo strlen($fruit);
        if (strlen($fruit) < 50){
            unset($another[$index]);
        }
    }

    // Re asign index
    $sentences = array_values($another);

    $countRow = 0;
    $allSearchedContentsAndLink = [];

    // Requesting google to search
    foreach ($sentences as $sentence) {
        // Search each sentence if the are any matches
        $url = 'https://www.google.com/search?q=' . urlencode($sentence);

        // create a new cURL resource
        $ch = curl_init();
        // set the URL and other options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36");

        $html = curl_exec($ch);
        curl_close($ch);
        
        // create a DOMDocument object and load the HTML content
        $doc = new DOMDocument();
        @$doc->loadHTML($html);

        // create a DOMXPath object to query the DOMDocument
        $xpath = new DOMXPath($doc);
        
        // use the XPath expression to find the element containing the search results
        $searchResults = $xpath->query("//div[@class='MjjYud']//div[contains(concat(' ', @class, ' '), ' kvH3mc BToiNc UK95Uc')]");

        $index = 0;
        foreach($searchResults as $searchResult){
            $linkBlock = $xpath->query("./div[1]//a/@href", $searchResult);
            $contentBlock = $xpath->query("./div[2]/div/span[2]", $searchResult);
            if ($contentBlock->length == 0){
                $contentBlock = $xpath->query("./div[2]/div/span[1]", $searchResult);   
            }
            // echo $contentBlock;
            $content = "";
            $link = $linkBlock->item(0)->textContent;

            if ($contentBlock->length != 0){   
                $content = $contentBlock->item(0)->textContent;
            }

            if ($link != "" && $content != ""){
                array_push($allSearchedContentsAndLink,  $content . "|" . $link);
            }
            
            $index += 1;
            if ($index >= 10){
                break;
            }
        }
        // echo $html;
        $countRow++;
        sleep(2);
    }

    // print_r($allSearchedContentsAndLink);
    $allSearchedContentsAndLink = ['https//javascript.com|this is the javasecript', 'https://samplelink.com|this is the sample link'];
    $sentencesPlagiarizedAsLink = [];
    $sentencesPlagiarized = [];
    $finalSimilarityWeight = 0;
    $sentences = ['the quick brown fox jumps over the lazy dog'];
    foreach ($sentences as $sentence) {
        $words = explode(" ", $sentence);
        
        $taggedAsPlagiarized = false;
        $thresholdWeightForPlagiarized = ceil(count($words) * 0.6);

        $finalWeight = 0;
        for ($index = 0; $index < count($allSearchedContentsAndLink); $index++)
        {
            $weight = 0;
            // Split the sentence to check for comparison
            foreach ($words as $word)
            {
                // Compare na dayun sa na search og sentence nga nakafocus
                $split = explode("|", $allSearchedContentsAndLink[$index]);
                $content = $split[0];
                $link = $split[1];
                
                if ($word != ""){
                    if (strpos($content, $word) !== false)
                    {
                        $weight += 1;
                        $finalWeight += 1;
                    }
                }
        
                if ($weight >= $thresholdWeightForPlagiarized)
                {
                    $taggedAsPlagiarized = true;
                    break;
                }
            }
        
            if ($taggedAsPlagiarized)
            {
                array_push($sentencesPlagiarizedAsLink, $link);
                array_push($sentencesPlagiarized, $sentence);

                $finalSimilarityWeight += 1;
                break;
            }
        }
    }
    // Count the length of plagiariezed sentenses
    $totalSentencesPlagiarized = count($sentencesPlagiarized);

    // get the final similarity
    $finalSimilarityPercent = (int)($finalSimilarityWeight / count($sentences) * 100);

    // get the originality
    $originality = 100-$finalSimilarityPercent;
    
    $countSentence = count($sentences);

    if ($countSentence == $countRow){
        // make a random string length 8
        $string = "abcdefjhigklmnopqrstuvwxyzABCDEFJHIGKLMNOPQRSTUVWXYZ1234567890";
        $randomString = substr(str_shuffle($string),0,8);

        // fetching data from the database coulumn all_research_data
        $getStatus = $conn->prepare("SELECT * FROM all_research_data WHERE id = :id");
        $id = htmlspecialchars(strip_tags($id));
        $getStatus->bindParam(":id", $id);

        $getStatus->execute();

        $statusResult = $getStatus->rowCount();

        if ($statusResult > 0){
            // if ($getStatus->execute(['id' => $id])){
            $get = $getStatus->fetch(PDO::FETCH_ASSOC);
        }
        $status = $get['status'];
        $authors = $get['authors'];

        // Insert Orginality and Similarity from their perspective ID
        $plagiarismResult = $conn->prepare("UPDATE all_research_data SET originality = :originality, similarity = :similarity, result_sign = :result_sign WHERE id = :id");
        $originality = htmlspecialchars(strip_tags($originality));
        $finalSimilarityPercent = htmlspecialchars(strip_tags($finalSimilarityPercent));
        $randomString = htmlspecialchars(strip_tags($randomString));
        $id = htmlspecialchars(strip_tags($id));

        $plagiarismResult->bindParam(":originality", $originality);
        $plagiarismResult->bindParam(":similarity", $finalSimilarityPercent);
        $plagiarismResult->bindParam(":result_sign", $randomString);
        $plagiarismResult->bindParam(":id", $id);

        $plagiarismResult->execute();

        $countResult = $plagiarismResult->rowCount();

        if ($countResult > 0){
        // if ($plagiarismResult->execute(['originality' => $originality, 'similarity' => $finalSimilarityPercent, 'result_sign' => $randomString, 'id' => $id])){

            $tester = false;

            $countSentencePlagiarized = count($sentencesPlagiarized);
            if (count($sentencesPlagiarized) == 0){
                $insertSql = $conn->prepare("INSERT INTO plagiarism_result SET authors = :authors, status = :status, originality = :originality, similarity = :similarity, result_sign = :result_sign");
                
                $status = htmlspecialchars(strip_tags($status));
                $originality = htmlspecialchars(strip_tags($originality));
                $finalSimilarityPercent = htmlspecialchars(strip_tags($finalSimilarityPercent));
                $randomString = htmlspecialchars(strip_tags($randomString));
                $authors = htmlspecialchars(strip_tags($authors));

                $insertSql->bindParam(":status", $status);
                $insertSql->bindParam(":originality", $originality);
                $insertSql->bindParam(":similarity", $finalSimilarityPercent);
                $insertSql->bindParam(":result_sign", $randomString);
                $insertSql->bindParam(":authors", $authors);

                $insertSql->execute();

                // $insertSql->execute(array(
                //     'status' => $status,
                //     'originality' => $originality,
                //     'similarity' => $finalSimilarityPercent,
                //     'result_sign' => $randomString,
                //     'authors' => $authors
                // ));
                $count = $insertSql->rowCount();
                
                if ($count > 0){
                    $tester = true;
                }else{
                    echo "something went wrong";
                }
            }

            // Insert from the table plagiarism_result
            for ($i = 0; $i < $countSentencePlagiarized; $i++){
                $resultSql = $conn->prepare("INSERT INTO plagiarism_result SET authors = :authors, status = :status, content = :content, link = :link, originality = :originality, similarity = :similarity, result_sign = :result_sign");

                $resultSql->execute(array(
                    'status' => $status,
                    'content' => $sentencesPlagiarized[$i],
                    'link' => $sentencesPlagiarizedAsLink[$i],
                    'originality' => $originality,
                    'similarity' => $finalSimilarityPercent,
                    'result_sign' => $randomString,
                    'authors' => $authors
                ));
                $count = $resultSql->rowCount();
                
                if ($count > 0){
                    $tester = true;
                }else{
                    echo "something went wrong";
                }
            }
            if ($tester){
                // Assigned SESSIONS
                $_SESSION['originality'] = $originality;
                $_SESSION['similar'] = $finalSimilarityPercent;
                $_SESSION['similarSentence'] = $sentencesPlagiarized;
                $_SESSION['link'] = $sentencesPlagiarizedAsLink;

                // Send to html front-end result
                header("Location: percentageResult.php");
            }
        }
    }

?>