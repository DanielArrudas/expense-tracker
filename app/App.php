<?php

declare(strict_types=1);
function getTransactionFiles(string $path): array
{
    $files = [];
    foreach (scandir($path) as $file) {
        if (is_dir($file))
            continue;
        
        $files[] = $path . $file;
    }
    return $files;
}
function getTransactions(string $fileName, ?callable $transactionHandler = null): array
{
    if (!file_exists($fileName)) {
        trigger_error('File "' . $fileName . '" does not exist.');
    }
    $file = fopen($fileName, 'r');

    fgetcsv($file);

    $transactions = [];

    while (($transaction = fgetcsv($file)) !== false) {
        if($transactionHandler !== null){
            $transaction = $transactionHandler($transaction);
        }
        $transactions[] = $transaction;
    }
        
    return $transactions;
}

function extractTransaction(array $transactionRow): array
{
    [$date, $checkNumber, $description, $amount] = $transactionRow;

    $amount = (float) str_replace(['$', ','], '', $amount);

    return[
        'date' => $date, 
        'checkNumber' => $checkNumber, 
        'description' => $description, 
        'amount' => $amount,
    ];
}

function calculateTotals(array $transactions): array
{
    $totals = ['totalIncome' => 0.0, 'totalExpense' => 0.0, 'netTotal' => 0.0];
    foreach ($transactions as $transaction) {
        if ($transaction['amount'] >= 0) {
            $totals['totalIncome'] += $transaction['amount'];
        } else {
            $totals['totalExpense'] += $transaction['amount'];
        }
    }

    $totals['netTotal'] = $totals['totalIncome'] + $totals['totalExpense'];

    return $totals;
}