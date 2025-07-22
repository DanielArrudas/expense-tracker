<!DOCTYPE html>
<html>

<head>
    <title>Transactions</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        table tr th,
        table tr td {
            padding: 5px;
            border: 1px #eee solid;
        }

        tfoot tr th,
        tfoot tr td {
            font-size: 20px;
        }

        tfoot tr th {
            text-align: right;
        }

        .income {
            color: green;
        }

        .expense {
            color: red;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Check #</th>
                <th scope="col">Description</th>
                <th scope="col">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($transactions)): ?>
                <?php foreach ($transactions as $transaction): ?>
                    <tr>
                        <td><?= formatDate($transaction['date']) ?></td>
                        <td><?= htmlspecialchars($transaction['checkNumber']) ?></td>
                        <td><?= htmlspecialchars($transaction['description']) ?></td>
                        <?php if ($transaction['amount'] < 0): ?>
                            <td class='expense'><?= formatAmount($transaction['amount']) ?></td>
                        <?php else: ?>
                            <td class='income'><?= formatAmount($transaction['amount']) ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total Income:</th>
                <td><?= formatAmount($totals['totalIncome'] ?? 0) ?></td>
            </tr>
            <tr>
                <th colspan="3">Total Expense:</th>
                <td><?= formatAmount($totals['totalExpense'] ?? 0) ?></td>
            </tr>
            <tr>
                <th colspan="3">Net Total:</th>
                <td><?= formatAmount($totals['netTotal'] ?? 0) ?></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>