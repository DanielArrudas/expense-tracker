<?php

declare(strict_types=1);
function get_transaction_files(string $path): array{
    $files = [];
    foreach (glob($path . '*.csv') as $file){
        $files[] = $file;
    }
    return $files;
}
function string_to_float($string): float
{
    $string = str_replace("$", "", $string);
    $string = str_replace(",", "", $string);
    $amount = floatval($string);
    return $amount;
}
function get_csvs_data(): array
{
    $csvs = get_transaction_files(FILES_PATH);
    $data = [];
    //Esse for passa por cada csv no transaction_files
    foreach($csvs as $csv) {
        //abrir csv
        $file = fopen($csv, "r");
        $j = 0;
        if ($file) {
            //passa por cada linha do csv e guarda no array data sem o header
            while (($line = fgetcsv($file)) !== false) {
                if ($j === 0) {
                    $j++;
                    continue;
                }
                $amount = string_to_float($line[3]);
                $data[] = ["Date" => $line[0], "Check #" => $line[1], "Description" => $line[2], "Amount" => $amount];
                $j++;
            }
            fclose($file);
        } else {
            echo 'Error opening file';
        }
    }

    return $data;
}
function calculate_totals(array $transactions): array
{
    $totals = ['income' => 0.0, 'expense' => 0.0, 'net' => 0.0];

    foreach ($transactions as $transaction) {
        if ($transaction['Amount'] > 0) {
            $totals['income'] += $transaction['Amount'];
        } else {
            $totals['expense'] += $transaction['Amount'];
        }
    }

    $totals['net'] = $totals['income'] + $totals['expense'];

    return $totals;
}

function format_date(string $date): string
{
    return date("M j, o", strtotime($date));
}

function format_amount(float $amount): string
{
    $formatted = number_format(abs($amount), 2);

    if($amount < 0){
        return "-$" . $formatted;
    }

    return "$" . $formatted;
}