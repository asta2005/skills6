<?php
// Stel de huidige maand en jaar in
$month = isset($_GET['month']) ? $_GET['month'] : date('m');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Bereken het aantal dagen in de maand en de eerste dag van de maand
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$firstDayOfMonth = date('w', strtotime("$year-$month-01"));

// Functie om de naam van de maand te krijgen
function getMonthName($monthNumber) {
    return date('F', mktime(0, 0, 0, $monthNumber, 1));
}

// Functie om een link te maken voor navigatie
function createNavLink($month, $year, $text) {
    return "<a href='?month=$month&year=$year'>$text</a>";
}

// Bereken vorige en volgende maand
$prevMonth = $month - 1;
$prevYear = $year;
if ($prevMonth < 1) {
    $prevMonth = 12;
    $prevYear--;
}

$nextMonth = $month + 1;
$nextYear = $year;
if ($nextMonth > 12) {
    $nextMonth = 1;
    $nextYear++;
}

?><!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda - <?php echo getMonthName($month) . " $year"; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 80%;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        .highlight {
            background-color: #add8e6;
        }
        .navigation {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <h1>Agenda - <?php echo getMonthName($month) . " $year"; ?></h1>

    <div class="navigation">
        <?php echo createNavLink($prevMonth, $prevYear, 'Vorige maand'); ?> |
        <?php echo createNavLink($nextMonth, $nextYear, 'Volgende maand'); ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>Zo</th>
                <th>Ma</th>
                <th>Di</th>
                <th>Wo</th>
                <th>Do</th>
                <th>Vr</th>
                <th>Za</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                // Vul lege cellen in voor de eerste dag van de maand
                for ($i = 0; $i < $firstDayOfMonth; $i++) {
                    echo '<td></td>';
                }

                // Vul de dagen van de maand in
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $currentDay = ($day == date('j') && $month == date('m') && $year == date('Y')) ? 'highlight' : '';
                    echo "<td class='$currentDay'>$day</td>";

                    // Maak een nieuwe rij na elke zaterdag
                    if (($day + $firstDayOfMonth) % 7 == 0) {
                        echo '</tr><tr>';
                    }
                }

                // Vul lege cellen in voor de resterende dagen van de week
                $remainingDays = (7 - ($daysInMonth + $firstDayOfMonth) % 7) % 7;
                for ($i = 0; $i < $remainingDays; $i++) {
                    echo '<td></td>';
                }
                ?>
            </tr>
        </tbody>
    </table>
</body>
</html>
