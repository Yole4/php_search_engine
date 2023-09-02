<?php
     require_once '../vendor/autoload.php'; // Include the PHPWord library
     require_once '../../res api/configuration/config.php';

     if (isset($_GET['id'])){
        $id = $_GET['id'];

        $sql = $conn->prepare("SELECT * FROM all_research_data WHERE id = :id");
        if ($sql->execute(['id' => $id])){
            $row = $sql->fetch(PDO::FETCH_ASSOC);
        }
        $resultSign = $row['result_sign'];
        $research = $row['research'];

        $resultSql = $conn->prepare("SELECT * FROM plagiarism_result WHERE result_sign = :result_sign");
        $resultSql->execute(['result_sign' => $resultSign]);
        $count = $resultSql->rowCount();

        $contentArray = array();
        $linkArray = array();
        $myStatus = "";
        $myOriginality = 0;
        $mySimilarity = 0;
        $myAuthors = "";

        if ($count > 0){
            while($getResult = $resultSql->fetch(PDO::FETCH_ASSOC)){
                $content = $getResult['content'];
                $link = $getResult['link'];
                $status = $getResult['status'];
                $originality = $getResult['originality'];
                $similarity = $getResult['similarity'];
                $authors = $getResult['authors'];

                $myAuthors = $authors;
                $myStatus = $status;
                $myOriginality = $originality;
                $mySimilarity = $similarity;

                $contentArray[] = $content;
                $linkArray[] = $link;
            }
        }

        date_default_timezone_set('Asia/Manila');
        $date = date('F j, Y');
        $time = date('g:i:a');

        if ($myOriginality >= 80){
            $remarks = "Good";
        }else{
            $remarks = "Plagiarized";
        }

        for ($p = 0; $p < count($contentArray); $p++){
            $contentArray[$p] = str_replace("&", "", $contentArray[$p]);
        }
        for ($o = 0; $o < count($linkArray); $o++){
            $linkArray[$o] = str_replace("&", "", $linkArray[$o]);
        }

        // if ($myOriginality != 0 && $mySimilarity != 0){
            // Create a new .docx file
     
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            // $sample = PhpOffice\PhpWord\Style\Font;
            $section = $phpWord->addSection();

            // Add a paragraph 'color' => 'FF0000'
            // $section->addText("Jose Rizal Memorial State University", ['size' => 22], ['align' => 'center']);
            $section->addText("Vice President of Research Development and Extension", ['size' => 22], ['align' => 'center']);
            $section->addText();
            $section->addText("Plagiarism Result", ['size' => 24], ['align' => 'center']);
            $section->addText();
            $section->addText("Title: $research", ['size' => 12], ['align' => 'left']);
            $section->addText("Author/s: $myAuthors", ['size' => 12], ['align' => 'left']);
            $section->addText("Date: $date", ['size' => 12], ['align' => 'left']);
            $section->addText("Time: $time", ['size' => 12], ['align' => 'left']);
            $section->addText("Status: $myStatus", ['size' => 12], ['align' => 'left']);
            $section->addText();
            $section->addText("Originality: $myOriginality%", ['size' => 12], ['color' => 'blue', 'align' => 'left']);
            $section->addText("Similarity: $mySimilarity%", ['color' => 'FF0000', 'size' => 12], ['align' => 'left']);
            $section->addText("Remarks: $remarks");
            $section->addText();
            
            if ($contentArray[0] != ""){
                $section->addText("Plagiarized Sentences", ['color' => 'FF0000', 'size' => 16], ['align' => 'center']);
                for ($i = 0; $i < count($contentArray); $i++){
                    $section->addText($i+1 .". $contentArray[$i]", ['color' => 'FF0000', 'size' => 12], ['align' => 'left']);
                    $section->addText($linkArray[$i]);
                    $section->addText();
                }
            }else{
                $section->addText("No Similarities Detected!", ['color' => 'blue', 'size' => 16], ['align' => 'center']);
            }   

            $filename = "certificate.docx";
            $phpWord->save($filename);

            // Set headers for file download
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');

            // Output the file content
            readfile($filename);

     }else{
        header("Location: ../../index.php");
     }
?>