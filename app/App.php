<?php

declare(strict_types=1);
function format_csv(array $files): array
{
    $files = array_diff($files, [".", ".."]);
    $newKeys = [];
    for ($i = 0; $i < count($files); $i++) {
        array_push($newKeys, $i);
    }
    $files = array_combine($newKeys, $files);
    return $files;
}
function scan_directory(string $path): array
{
    $files = scandir($path);
    $files = format_csv($files);
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
define('DATA', get_csvs_data());
function print_csv()
{
    foreach (DATA as $line) {
        $line["Date"] = date("M j, o", strtotime($line["Date"]));
        echo "<tr>";
        echo "<td>" . $line["Date"] . "</td>";
        echo "<td>" . $line["Check #"] . "</td>";
        echo "<td>" . $line["Description"] . "</td>";
        $amount = number_format($line["Amount"], 2, ".", ",");
        if ($line["Amount"] < 0) {
            $amount = substr_replace($amount, "$", 1, 0);
            echo "<td class='expense'>" . $amount . "</td>";
        }
        if ($line["Amount"] > 0)
            echo "<td class='income'>$" . $amount . "</td>";
        echo "</tr>";
    }
}
function total_income(): float
{
    $totalIncome = 0.0;
    foreach (DATA as $item) {
        if ($item["Amount"] > 0) {
            $totalIncome += $item["Amount"];
        }
    }
    return $totalIncome;
}
function print_total_income(): void
{
    $totalIncome = total_income();
    $amount = number_format($totalIncome, 2, ".", ",");
    echo "$" . $amount;
}
function total_expense(): float
{
    $totalExpense = 0.0;
    foreach (DATA as $item) {
        if ($item["Amount"] < 0) {
            $totalExpense += $item["Amount"];
        }
    }
    return $totalExpense;
}

function print_total_expense(): void
{
    $totalExpense = total_expense();
    $amount = number_format($totalExpense, 2, ".", ",");
    if ($totalExpense === 0.0) {
        echo "$" . $amount;
    } else {
        $amount = substr_replace($amount, "$", 1, 0);
        echo $amount;
    }
}
function net_total(): float
{
    $netTotal = total_income() + total_expense();
    return $netTotal;
}

function print_net_total(): void
{
    $netTotal = net_total();
    $amount = number_format($netTotal, 2, ".", ",");
    if ($netTotal >= 0.0) {
        echo "$" . $amount;
    } else {
        $amount = substr_replace($amount, "$", 1, 0);
        echo $amount;
    }
}
