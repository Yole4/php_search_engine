<?php
require_once("../../../../configuration/config.php");

    if (isset($_POST['generate'])){
        $RorE = $_POST['RorE'];
        $campus = $_POST['campus'];
        $inputDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
    
        date_default_timezone_set('Asia/Manila');
        $date = date('F j, Y g:i:a');

        $firstInput = date('Y-m-d', strtotime('-1 day', strtotime($inputDate)));
        $secondInput = date('Y-m-d', strtotime('+1 day', strtotime($endDate)));


        $sql = "SELECT * FROM all_research_data WHERE date BETWEEN :inputDate AND :endDate";
        $stmt = $conn->prepare($sql);

        // Bind values to placeholders
        // $stmt->bindParam(':RorE', $RorE);
        $stmt->bindParam(':inputDate', $firstInput);
        $stmt->bindParam(':endDate', $secondInput);

        // Execute query
        $stmt->execute();

        // Fetch data from result
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count = count($result);
            
            // Display data

            $startDate = date('F j, Y', strtotime($inputDate));
            $eDate = date('F j, Y', strtotime($endDate));

            require_once '../../../../../plagiarism/vendor/autoload.php'; // Include the PHPWord library

            // Create a new .docx file
            
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            // $sample = PhpOffice\PhpWord\Style\Font;
            $section = $phpWord->addSection();

            $section->addText($RorE, array('size' => 20, 'align' => 'center'));
            $section->addText($campus, array('size' => 20, 'align' => 'center'));
            $section->addText();
            $section->addText("From ".$startDate. " to ". $eDate, array('bold' => true, 'size' => 14));

            // Add a table
            $table = $section->addTable();

            $table->addRow();
            $table->addCell(5000)->addText("RESEARCH", array('bold' => true));
            $table->addCell(2000)->addText("CAMPUS", array('bold' => true));
            $table->addCell(1000)->addText("COLLEGE", array('bold' => true));

            foreach($result as $index => $row){
                if ($RorE == "Research"){
                    
                    $checker = $row['campus'];
                    $isDelete = $row['isDelete'];
                    
                    if (($checker == $campus) && ($isDelete == "not")){
                        $table->addRow();
                        $table->addCell(5000)->addText($row['research']);
                        $table->addCell(2000)->addText($row['campus']);
                        $table->addCell(1000)->addText($row['college']);
                    }
                }
                else if ($RorE == "Extension"){
                    $checker = $row['campus'];
                    $isDelete = $row['isDelete'];
                    
                    if (($checker == $campus) && ($isDelete == "not")){
                        $table->addRow();
                        $table->addCell(5000)->addText($row['research']);
                        $table->addCell(2000)->addText($row['campus']);
                        $table->addCell(1000)->addText($row['college']);
                    }
                }

            }

            // Save the .docx file $April 22, 2023 - April 23, 2023 (Research -> Dapitan)
            $filename = "$startDate - $eDate ($RorE - $campus).docx";
            // $filename = 'example.docx';
            $phpWord->save($filename);

            // Set headers for file download
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');

            // Output the file content
            readfile($filename);

            // Delete the file after download
            unlink($filename);
    }else{
        header("../../../../../index.php");
    }
?>
