
<!DOCTYPE html>
<html>
<body>
<?php

// test_db.php
require_once __DIR__ . '/init.php';

try {
    $db = new Database();
    echo "Database connection successful!";
    
    // Test query
    $stmt = $db->getConnection()->query("SELECT 1");
    $result = $stmt->fetch();
    echo "<pre>Test query result: "; print_r($result); echo "</pre>";
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}



        session_unset();
        session_destroy();






   echo dirname(__FILE__);
   echo "<br>";
   echo __DIR__;

   define('APP_ROOT', __DIR__);
 echo "<br>";
   echo $_SERVER['DOCUMENT_ROOT'];

   echo "<br>";
   echo APP_ROOT;
?>
</body>
</html>



