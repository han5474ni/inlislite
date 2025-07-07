<?php
/**
 * Project Cleanup Verification Script
 * Verifies that all files are in their correct locations after cleanup
 */

echo "=== INLISLite v3.0 Project Cleanup Verification ===\n\n";

$errors = [];
$warnings = [];
$success = [];

// Check for removed files (should not exist)
$removedFiles = [
    'public/assets/js/admin/profile-new.js',
    'public/assets/js/admin/registration_detail.js', 
    'public/assets/js/admin/sidebar.js',
    'public/assets/css/admin/registration_detail.css',
    'public/assets/css/admin/sidebar.css',
    'app/Views/admin/registration_detail.php',
    'app/Views/admin/registration_form.php',
    'app/Views/admin/user_management_form.php',
    'app/Views/admin/auth/simple_login.php',
    'app/Controllers/admin/SimpleLoginController.php',
    'app/Controllers/admin/SecureAuthController.php'
];

echo "1. Checking removed files (should not exist):\n";
foreach ($removedFiles as $file) {
    if (file_exists($file)) {
        $errors[] = "❌ File still exists: $file";
    } else {
        $success[] = "✅ File correctly removed: $file";
    }
}

// Check for renamed files (should exist in new location)
$renamedFiles = [
    'app/Controllers/admin/AuthController.php' => 'app/Controllers/admin/SecureAuthController.php',
    'app/Views/admin/auth/main_login.php' => 'app/Views/admin/auth/secure_login.php'
];

echo "\n2. Checking renamed files:\n";
foreach ($renamedFiles as $newFile => $oldFile) {
    if (file_exists($newFile)) {
        $success[] = "✅ File correctly renamed: $oldFile → $newFile";
    } else {
        $errors[] = "❌ Renamed file missing: $newFile";
    }
    
    if (file_exists($oldFile)) {
        $warnings[] = "⚠️ Old file still exists: $oldFile";
    }
}

// Check for essential files (should exist)
$essentialFiles = [
    'app/Controllers/admin/AuthController.php',
    'app/Controllers/admin/AdminController.php',
    'app/Controllers/Home.php',
    'app/Views/admin/registration_view.php',
    'app/Views/admin/registration.php',
    'app/Views/admin/dashboard.php',
    'public/assets/js/admin/dashboard.js',
    'public/assets/js/admin/registration_view.js',
    'public/assets/css/admin/registration_view.css',
    'app/Config/Routes.php'
];

echo "\n3. Checking essential files (should exist):\n";
foreach ($essentialFiles as $file) {
    if (file_exists($file)) {
        $success[] = "✅ Essential file exists: $file";
    } else {
        $errors[] = "❌ Essential file missing: $file";
    }
}

// Check Routes.php for correct controller references
echo "\n4. Checking Routes.php for correct references:\n";
$routesContent = file_get_contents('app/Config/Routes.php');

if (strpos($routesContent, 'AuthController') !== false) {
    $success[] = "✅ Routes.php references AuthController";
} else {
    $errors[] = "❌ Routes.php missing AuthController references";
}

if (strpos($routesContent, 'SecureAuthController') !== false) {
    $warnings[] = "⚠️ Routes.php still references old SecureAuthController";
}

if (strpos($routesContent, 'SimpleLoginController') !== false) {
    $warnings[] = "⚠️ Routes.php still references removed SimpleLoginController";
}

// Check for duplicate function definitions in JavaScript
echo "\n5. Checking for duplicate JavaScript functions:\n";
$jsFiles = [
    'public/assets/js/admin/dashboard.js',
    'public/assets/js/admin/registration_view.js'
];

$functionCounts = [];
foreach ($jsFiles as $jsFile) {
    if (file_exists($jsFile)) {
        $content = file_get_contents($jsFile);
        // Check for showToast function
        if (preg_match_all('/function\s+showToast\s*\(/', $content, $matches)) {
            $count = count($matches[0]);
            if ($count > 0) {
                $functionCounts[$jsFile] = $count;
            }
        }
    }
}

if (count($functionCounts) > 1) {
    $warnings[] = "⚠️ showToast function found in multiple files: " . implode(', ', array_keys($functionCounts));
} else {
    $success[] = "✅ No duplicate showToast functions found";
}

// Summary
echo "\n" . str_repeat("=", 50) . "\n";
echo "VERIFICATION SUMMARY\n";
echo str_repeat("=", 50) . "\n";

echo "\n✅ SUCCESS (" . count($success) . " items):\n";
foreach ($success as $item) {
    echo "  $item\n";
}

if (!empty($warnings)) {
    echo "\n⚠️ WARNINGS (" . count($warnings) . " items):\n";
    foreach ($warnings as $item) {
        echo "  $item\n";
    }
}

if (!empty($errors)) {
    echo "\n❌ ERRORS (" . count($errors) . " items):\n";
    foreach ($errors as $item) {
        echo "  $item\n";
    }
    echo "\nPlease fix the errors above before proceeding.\n";
    exit(1);
} else {
    echo "\n🎉 PROJECT CLEANUP VERIFICATION PASSED!\n";
    echo "All files are correctly organized and no critical issues found.\n";
    
    if (!empty($warnings)) {
        echo "\nNote: Please review the warnings above for potential improvements.\n";
    }
}

echo "\nCleanup completed successfully! ✨\n";
?>