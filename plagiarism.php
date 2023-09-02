<?php
// ini_set('max_execution_time', 300);
session_start();

// $filename = "sample.txt";
// $file = fopen($filename, "r");
// $fileContents = fread($file, filesize($filename));
// fclose($file);

// // Split the documents
// $sentences = explode(".", $fileContents);
// for ($x = 0; $x < count($sentences); $x++)
// {
//     if ($sentences[$x] == "" || $sentences[$x] == " ")
//     {
//         unset($sentences[$x]);
//     }
// }
// print_r($sentences);
// // $empty = ['A use case is depicted as a horizontal this ellipse and depicts a series of behaviors that give an actor something of quantifiable value.', '', 'that the data gained is from the certain types of', 'data.'];
// // $sentences = array_filter($empty);
// $allSearchedContents = [];
// foreach ($sentences as $sentence) {
//     // Search each sentence if the are any matches
//     $url = 'https://www.google.com/search?q=' . urlencode($sentence);

//     // create a new cURL resource
//     $ch = curl_init();
//     // set the URL and other options
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36");

//     $html = curl_exec($ch);
//     curl_close($ch);
    
//     // create a DOMDocument object and load the HTML content
//     $doc = new DOMDocument();
//     @$doc->loadHTML($html);

//     // create a DOMXPath object to query the DOMDocument
//     $xpath = new DOMXPath($doc);
    
//     // use the XPath expression to find the element containing the search results
//     $searchResults = $xpath->query("//div[@class='MjjYud']//div[contains(concat(' ', @class, ' '), ' VwiC3b ') or contains(concat(' ', @class, ' '), ' yXK7lf ') or contains(concat(' ', @class, ' '), ' MUxGbd ') or contains(concat(' ', @class, ' '), ' yDYNvb ') or contains(concat(' ', @class, ' '), ' lyLwlc ') or contains(concat(' ', @class, ' '), ' lEBKkf ')]");

//     foreach($searchResults as $searchResult)
//     {
//         array_push($allSearchedContents, $searchResult->textContent);
//     }

//     sleep(2);
// }

// $sentencesPlagiarized = [];
// $finalSimilarityWeight = 0;
// foreach ($sentences as $sentence) {
//     $words = explode(" ", $sentence);
    
//     $taggedAsPlagiarized = false;
//     $thresholdWeightForPlagiarized = ceil(count($words) * 0.6);

//     $finalWeight = 0;
//     foreach ($allSearchedContents as $content) 
//     {
//         $weight = 0;
//         // Split the sentence to check for comparison
//         foreach ($words as $word)
//         {
//             // Compare na dayun sa na search og sentence nga nakafocus
//             if (strpos($content, $word) !== false)
//             {
//                 $weight += 1;
//                 $finalWeight += 1;
//             }
    
//             if ($weight >= $thresholdWeightForPlagiarized)
//             {
//                 $taggedAsPlagiarized = true;
//                 break;
//             }
//         }
    
//         if ($taggedAsPlagiarized)
//         {
//             array_push($sentencesPlagiarized, $sentence);

//             $finalSimilarityWeight += 1;
//             break;
//         }
//     }
// }


// // $similarity = (int)($finalSimilarityWeight / count($sentences) * 100);
// // // echo "Similarity: $similarity%";

// // $originality = 100-$similarity;
// // echo "Originality: $originality <br>";
// // echo "Similarities: $similarity";

// // $countSentence = count($sentences);
// // echo "Count Row: $countRow <br>";
// // echo "Count Sentence: $countSentence";

// // if ($countSentence > $countRow){
// //     $_SESSION['originality'] = $originality;
// //     $_SESSION['similar'] = $similarity;
// //     header("Location: plagiarism/percentageResult.php");
// // }else{
// //     header("Location: percentage.php?already=Not plagiarize internet problem!");
// // }
?>



<?php
ini_set('max_execution_time', 300);

$filename = "sample.txt";
$file = fopen($filename, "r");
$fileContents = fread($file, filesize($filename));
fclose($file);

// Split the documents
$sentences = explode(".", $fileContents);
for ($x = 0; $x < count($sentences); $x++)
{
    if ($sentences[$x] == "" || $sentences[$x] == " ")
    {
        unset($sentences[$x]);
    }
}

    $countRow = 0;
    $allSearchedContentsAndLink = [];
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
        foreach($searchResults as $searchResult)
        {
            $linkBlock = $xpath->query("./div[1]//a/@href", $searchResult);
            $contentBlock = $xpath->query("./div[2]/div/span[2]", $searchResult);
            if ($contentBlock->length == 0)
            {
                $contentBlock = $xpath->query("./div[2]/div/span[1]", $searchResult);   
            }
            // echo $contentBlock;
            $content = "";
            $link = $linkBlock->item(0)->textContent;

            if ($contentBlock->length != 0)
            {   
                $content = $contentBlock->item(0)->textContent;
            }

            if ($link != "" && $content != "")
            {
                array_push($allSearchedContentsAndLink,  $content . "|" . $link);
            }
            
            $index += 1;
            if ($index >= 10)
            {
                break;
            }
        }
        $countRow++;
        sleep(2);
    }

    // print_r($allSearchedContentsAndLink);

    $sentencesPlagiarizedAsLink = [];
    $sentencesPlagiarized = [];
    $finalSimilarityWeight = 0;
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

    $totalSentencesPlagiarized = count($sentencesPlagiarized);

    $finalSimilarityPercent = (int)($finalSimilarityWeight / count($sentences) * 100);

    $originality = 100-$finalSimilarityPercent;

    $countSentence = count($sentences);

    if ($countSentence == $countRow){
        $_SESSION['originality'] = $originality;
        $_SESSION['similar'] = $finalSimilarityPercent;
        $_SESSION['similarSentence'] = $sentencesPlagiarized;
        $_SESSION['link'] = $sentencesPlagiarizedAsLink;
        header("Location: plagiarism/percentageResult.php");
    }
?>





