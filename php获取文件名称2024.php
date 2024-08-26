<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.css">
    <script src="jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.js"></script>
    <script src="https://cdn.staticfile.org/angular.js/1.4.6/angular.min.js"></script> 
    <style>
        .number-table {
            width: 60%;
            margin: 0 auto;
            border-collapse: collapse;
        }
        .number-table td {
            width: 20%;
            text-align: center;
            padding: 5px;
        }
        .number-table input[type="checkbox"] {
            margin-right: 5px;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        .button-container button {
            font-size: 18px;
            padding: 10px 20px;
            margin: 10px 0;
            display: block;
            width: 60%;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>

<?php
    function getCurrentFileName() {
        return basename(__FILE__);
    }

    function getRandomNumbers() {
        $frontNumbers = range(1, 35);
        $backNumbers = range(1, 12);

        $selectedFrontNumbersCount = rand(1, 5);
        $selectedFrontNumbers = array_rand(array_flip($frontNumbers), $selectedFrontNumbersCount);

        $selectedBackNumbersCount = rand(1, 2);
        $selectedBackNumbers = array_rand(array_flip($backNumbers), $selectedBackNumbersCount);

        if (!is_array($selectedFrontNumbers)) {
            $selectedFrontNumbers = [$selectedFrontNumbers];
        }
        if (!is_array($selectedBackNumbers)) {
            $selectedBackNumbers = [$selectedBackNumbers];
        }

        return [
            'front' => $selectedFrontNumbers,
            'back' => $selectedBackNumbers
        ];
    }

    $randomNumbers = isset($_POST['randomize']) ? getRandomNumbers() : ['front' => [], 'back' => []];
?>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <h3>前区号码</h3>
    <table class="number-table">
        <tr>
            <?php for ($i = 1; $i <= 35; $i++): ?>
                <td>
                    <label>
                        <input type="checkbox" name="front[]" value="<?php echo $i; ?>" <?php echo in_array($i, $randomNumbers['front']) ? 'checked' : ''; ?>>
                        <?php echo $i; ?>
                    </label>
                </td>
                <?php if ($i % 5 == 0): ?>
                    </tr><tr>
                <?php endif; ?>
            <?php endfor; ?>
        </tr>
    </table>

    <h3>后区号码</h3>
    <table class="number-table">
        <tr>
            <?php for ($i = 1; $i <= 12; $i++): ?>
                <td>
                    <label>
                        <input type="checkbox" name="back[]" value="<?php echo $i; ?>" <?php echo in_array($i, $randomNumbers['back']) ? 'checked' : ''; ?>>
                        <?php echo $i; ?>
                    </label>
                </td>
                <?php if ($i % 4 == 0): ?>
                    </tr><tr>
                <?php endif; ?>
            <?php endfor; ?>
        </tr>
    </table>

    <h4>当前文件名: <?php echo getCurrentFileName(); ?></h4>
    
    <!-- 随机选中按钮和提交按钮 -->
    <div class="button-container">
        <button type="submit" name="randomize">随机选中号码</button>
        <br/>
        <button type="submit">提交选中号码</button>
    </div>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['randomize'])) {
    $selectedFrontNumbers = isset($_POST['front']) ? $_POST['front'] : [];
    $selectedBackNumbers = isset($_POST['back']) ? $_POST['back'] : [];
    $filename = getCurrentFileName();

    echo "<div>";
    echo "<h3>结果</h3>";
    echo "<p>前区选中的号码: " . implode(", ", $selectedFrontNumbers) . "</p>";
    echo "<p>后区选中的号码: " . implode(", ", $selectedBackNumbers) . "</p>";
    echo "<p>提交的文件名: " . htmlspecialchars($filename) . "</p>";
    echo "</div>";
}
?>

</body>
</html>
