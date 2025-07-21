<?php

declare(strict_types = 1);
function format_csv(array $files) :array{
    $files = array_diff($files, [".", ".."]);
    $newKeys = [];
    for($i = 0; $i < count($files); $i++){
        array_push($newKeys,$i);
    }
    $files = array_combine($newKeys, $files);
    return $files;
}
function scan_directory(string $path): array{
    $files = scandir($path);
    $files = format_csv($files);
    return $files;
}
function get_csvs_data(): array{
    $csvs = scan_directory(FILES_PATH);
    $data = [];
    //Esse for passa por cada csv no transaction_files
    for ($i = 0; $i < count($csvs); $i++) {
        //abrir csv
        $file = fopen(FILES_PATH . "/" . $csvs[$i], "r");
        $j = 0;
        if ($file) {
            //passa por cada linha do csv e guarda no array data sem o header
            while (($line = fgetcsv($file)) !== false) {
                if($j === 0){
                    $j++;
                    continue;
                }
                $data[] = ["Date" => $line[0], "Check #" => $line[1], "Description" => $line[2], "Amount" => $line[3]]; 
                $j++;
            }
            fclose($file);
        } else {
            echo 'Error opening file';
        }
    }
    
    return $data;
}
function print_csv() {
    $data = get_csvs_data();
    foreach ($data as $line) {
        echo "<tr>";
        echo "<td>" . $line["Date"] . "</td>";
        echo "<td>" . $line["Check #"] . "</td>";
        echo "<td>" . $line["Description"] . "</td>";
        echo "<td>" . $line["Amount"] . "</td>";
        echo "</tr>";
    }
}