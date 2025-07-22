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
            <tr>
                <?php
                print_csv();
                ?>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total Income:</th>
                <td>
                    <?php
                    print_total_income();
                    ?>
                </td>
            </tr>
            <tr>
                <th colspan="3">Total Expense:</th>
                <td>
                    <?php
                    print_total_expense();
                    ?>
                </td>
            </tr>
            <tr>
                <th colspan="3">Net Total:</th>
                <td>
                    <?php
                    print_net_total();
                    ?>
                </td>
            </tr>
        </tfoot>
    </table>
</body>

</html>