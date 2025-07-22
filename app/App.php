<?php

declare(strict_types=1);
function getTransactionFiles(string $path): array
{
    $files = [];
    foreach (glob($path . '*.csv') as $file) {
        $files[] = $file;
    }
    return $files;
}
function getTransactions(): array
{
    $csvs = getTransactionFiles(FILES_PATH);
    $data = [];
    //Esse for passa por cada csv no transaction_files
    foreach ($csvs as $csv) {
        //abrir csv
        $file = fopen($csv, 'r');
        $j = 0;
        if ($file) {
            //passa por cada linha do csv e guarda no array data sem o header
            while (($line = fgetcsv($file)) !== false) {
                if ($j === 0) {
                    $j++;
                    continue;
                }
                $amount = (float) str_replace(['$', ','], '', $line[3]);
                $data[] = ['Date' => $line[0], 'Check #' => $line[1], 'Description' => $line[2], 'Amount' => $amount];
                $j++;
            }
            fclose($file);
        } else {
            echo 'Error opening file';
        }
    }

    return $data;
}
function calculateTotals(array $transactions): array
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