<?php
/**
 * DOMPDF Dependency Checker
 * Check if all required DOMPDF files exist on the server
 */

$dompdf_path = __DIR__ . '/application/third_party/dompdf/';

echo "<h2>DOMPDF Dependency Check</h2>";
echo "<pre>";

// Check main files
$files_to_check = array(
    'autoload.inc.php',
    'src/Autoloader.php',
    'lib/html5lib/Parser.php',
    'lib/php-font-lib/src/FontLib/Autoloader.php',
    'lib/php-svg-lib/src/autoload.php',
    'lib/php-css-parser/lib/Sabberworm/CSS/Parser.php',
);

foreach ($files_to_check as $file) {
    $full_path = $dompdf_path . $file;
    $exists = file_exists($full_path) ? 'EXISTS' : 'MISSING';
    echo "[" . $exists . "] " . $file . "\n";
}

echo "</pre>";

// Try to load the autoloader
echo "<h3>Attempting to load DOMPDF...</h3>";
try {
    require_once $dompdf_path . 'autoload.inc.php';
    echo "<p style='color: green;'>✓ DOMPDF loaded successfully!</p>";
    if (class_exists('Dompdf\DOMPDF')) {
        echo "<p style='color: green;'>✓ Dompdf\\DOMPDF class found!</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}
?>
