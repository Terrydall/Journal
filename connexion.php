
<?php
 
$host = 'localhost';
$dbname = 'journal';
$username = 'root';
$conn = mysqli_connect($host, $username, '', $dbname);
 
mysqli_close($conn);
 
$host = 'localhost';
$dbname = 'journal';
$username = 'root';
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username);
    
} catch (PDOException $e) {
    
    die("Impossible de se connecter à la base de données $dbname :" . $e->getMessage());
}
?>
 