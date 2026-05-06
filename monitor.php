<?php

function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= pow(1024, $pow);

    return round($bytes, $precision) . ' ' . $units[$pow];
}

// CPU Load
$load = sys_getloadavg();

// Memory Usage
$free = shell_exec('free -b');
$free = explode("\n", trim($free));
$mem = preg_split('/\s+/', $free[1]);

$totalMemory = $mem[1];
$usedMemory = $mem[2];
$freeMemory = $mem[3];

// Disk Usage
$diskTotal = disk_total_space('/');
$diskFree = disk_free_space('/');
$diskUsed = $diskTotal - $diskFree;

?>

<!DOCTYPE html>
<html>
<head>
    <title>EC2 Resource Monitor</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            padding: 30px;
        }

        .card {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        h1 {
            color: #333;
        }
    </style>
</head>
<body>

<h1>AWS EC2 Resource Usage</h1>

<div class="card">
    <h2>CPU Load</h2>
    <p>1 Minute: <?php echo $load[0]; ?></p>
    <p>5 Minutes: <?php echo $load[1]; ?></p>
    <p>15 Minutes: <?php echo $load[2]; ?></p>
</div>

<div class="card">
    <h2>Memory Usage</h2>
    <p>Total RAM: <?php echo formatBytes($totalMemory); ?></p>
    <p>Used RAM: <?php echo formatBytes($usedMemory); ?></p>
    <p>Free RAM: <?php echo formatBytes($freeMemory); ?></p>
</div>

<div class="card">
    <h2>Disk Usage</h2>
    <p>Total Disk: <?php echo formatBytes($diskTotal); ?></p>
    <p>Used Disk: <?php echo formatBytes($diskUsed); ?></p>
    <p>Free Disk: <?php echo formatBytes($diskFree); ?></p>
</div>

</body>
</html>
