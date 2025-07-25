<?php
function formatDate(string $date): string
{
    return date('M j, Y', strtotime($date));
}

function formatAmount(float $amount): string
{
    $isNegative = $amount < 0;

    return ($isNegative ? '-' : '') . '$' . number_format(abs($amount), 2);
}