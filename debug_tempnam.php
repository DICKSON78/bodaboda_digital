<?php

require_once __DIR__ . '/vendor/autoload.php';

echo "=== tempnam() Diagnostic ===\n";

// Test 1: Basic tempnam functionality
echo "1. Testing basic tempnam():\n";
$tempFile = tempnam(sys_get_temp_dir(), 'test');
if ($tempFile) {
    echo "   SUCCESS: $tempFile\n";
    unlink($tempFile);
} else {
    echo "   FAILED: Could not create temp file\n";
}

// Test 2: Check temp directory permissions
echo "\n2. Temp directory permissions:\n";
$tempDir = sys_get_temp_dir();
echo "   Temp dir: $tempDir\n";
echo "   Writable: " . (is_writable($tempDir) ? 'YES' : 'NO') . "\n";
echo "   Permissions: " . substr(sprintf('%o', fileperms($tempDir)), -4) . "\n";

// Test 3: Laravel session storage path
echo "\n3. Laravel session storage:\n";
$sessionPath = __DIR__ . '/storage/framework/sessions';
echo "   Session path: $sessionPath\n";
echo "   Exists: " . (file_exists($sessionPath) ? 'YES' : 'NO') . "\n";
echo "   Writable: " . (is_writable($sessionPath) ? 'YES' : 'NO') . "\n";
if (file_exists($sessionPath)) {
    echo "   Permissions: " . substr(sprintf('%o', fileperms($sessionPath)), -4) . "\n";
}

// Test 4: Try creating a session file like Laravel does
echo "\n4. Testing Laravel-style session file creation:\n";
try {
    $sessionFile = tempnam($sessionPath, 'sess_');
    if ($sessionFile) {
        echo "   SUCCESS: $sessionFile\n";
        unlink($sessionFile);
    } else {
        echo "   FAILED: Could not create session file\n";
    }
} catch (Exception $e) {
    echo "   EXCEPTION: " . $e->getMessage() . "\n";
}

// Test 5: Check if we're running out of disk space
echo "\n5. Disk space check:\n";
$freeSpace = disk_free_space($tempDir);
$totalSpace = disk_total_space($tempDir);
echo "   Free space: " . number_format($freeSpace / 1024 / 1024, 2) . " MB\n";
echo "   Total space: " . number_format($totalSpace / 1024 / 1024, 2) . " MB\n";

echo "\n=== End Diagnostic ===\n";
