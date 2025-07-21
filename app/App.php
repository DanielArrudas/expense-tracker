<?php

declare(strict_types = 1);
//TODO: trocar para remover qualquer valor em um array
function delete_dots($files) :array{
    $files = array_diff($files, ['.', '..']);
    $newKeys = [];
    for($i = 0; $i < count($files); $i++){
        array_push($newKeys,$i);
    }
    $files = array_combine($newKeys, $files);
    return $files;
}
function scan_directory($path): array{
    $files = scandir($path);
    $files = delete_dots($files);
    return $files;
}
function get_csvs_data($csvs): array{
    $data = [];
    //Esse for passa por cada csv no transaction_files
    for ($i = 0; $i < count($csvs); $i++) {
        //abrir csv
        $file = fopen(FILES_PATH . "/" . $csvs[$i], "r");
        if ($file) {
            $j = 0;
            while (($line = fgetcsv($file)) !== false) {
                if ($j === 0){
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
function get_csv() {
    $csvs = scan_directory(FILES_PATH);
    $data = get_csvs_data($csvs);

    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}
get_csv();