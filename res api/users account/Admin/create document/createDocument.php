<?php
require_once("../../../configuration/config.php");

    if (isset($_POST['generate'])){
        $RorE = $_POST['selectOption'];
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

            require_once '../../../../plagiarism/vendor/autoload.php'; // Include the PHPWord library

            // Create a new .docx file
            
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            // $sample = PhpOffice\PhpWord\Style\Font;
            $section = $phpWord->addSection();

            // Add a paragraph
            // $section->addText($RorE, array('size' => 20, 'align' => 'center'));
            if ($RorE == "All"){
                $section->addText("Research AND Extension", array('size' => 20, 'align' => 'center'));
            }else{
                $section->addText($RorE, array('size' => 20, 'align' => 'center'));
            }
            $section->addText();
            $section->addText("From ".$startDate. " to ". $eDate, array('bold' => true, 'size' => 14));

            // Add a table
            $table = $section->addTable();

            $table->addRow();
            $table->addCell(5000)->addText("TITLE", array('bold' => true));
            $table->addCell(1000)->addText("CAMPUS", array('bold' => true));
            $table->addCell(1000)->addText("COLLEGE", array('bold' => true));

            foreach($result as $index => $row){
                if ($RorE == "All"){

                    $isDelete = $row['isDelete'];

                    if ($isDelete == "not"){
                        $table->addRow();
                        $table->addCell(5000)->addText($row['research']);
                        $table->addCell(1000)->addText($row['campus']);
                        $table->addCell(1000)->addText($row['college']);
                    }

                    
                }else if ($RorE == "Research"){
                    
                    $checker = $row['RorE'];
                    $isDelete = $row['isDelete'];
                    
                    if (($checker == "Research") && ($isDelete == "not")){
                        $table->addRow();
                        $table->addCell(5000)->addText($row['research']);
                        $table->addCell(1000)->addText($row['campus']);
                        $table->addCell(1000)->addText($row['college']);

                        
                    }
                }
                else if ($RorE == "Extension"){

                    $isDelete = $row['isDelete'];
                    $checker = $row['RorE'];

                    if (($checker == "Extension") && ($isDelete == "not")){
                        $table->addRow();
                        $table->addCell(5000)->addText($row['research']);
                        $table->addCell(1000)->addText($row['campus']);
                        $table->addCell(1000)->addText($row['college']);

                        
                    }
                }

            }

            // Save the .docx file
            // $filename = 'example.docx';
            if ($RorE == "All"){
                $fileExtension = "Research & Extension";
            }else{
                $fileExtension = $RorE;
            }
            $filename = "$startDate - $eDate ($fileExtension).docx";
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
        header("../../../../index.php");
    }
?>
