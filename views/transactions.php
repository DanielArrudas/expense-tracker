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
                        <td><?= format_date($transaction['Date']) ?></td>
                        <td><?= htmlspecialchars($transaction['Check #']) ?></td>
                        <td><?= htmlspecialchars($transaction['Description']) ?></td>
                        <?php if ($transaction['Amount'] < 0): ?>
                            <td class="expense"><?= format_amount($transaction['Amount']) ?></td>
                        <?php else: ?>
                            <td class="income"><?= format_amount($transaction['Amount']) ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total Income:</th>
                <td><?php echo format_amount($totals['income']); ?></td>
            </tr>
            <tr>
                <th colspan="3">Total Expense:</th>
                <td><?php echo format_amount($totals['expense']); ?></td>
            </tr>
            <tr>
                <th colspan="3">Net Total:</th>
                <td><?php echo format_amount($totals['net']); ?></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>