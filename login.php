<?php
include 'header.php';
include 'connexion.php';
session_start();

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Requête SQL pour vérifier l'existence de l'utilisateur
    $sql = "SELECT * FROM utilisateurs WHERE email = :email";
    $result = $conn->prepare($sql);
    $result->bindValue(':email', $email);
    $result->execute();

    if ($result) {
        $row = $result->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $stored_hashed_password = $row["password"];

            if (password_verify($password, $stored_hashed_password)) {
                // Mot de passe correct, démarrer une session
                $_SESSION["email"] = $email;
                // Rediriger vers une page sécurisée
                header("Location: index.php");
            } else {
                // Mot de passe incorrect, afficher un message d'erreur
                echo "<br> Mot de passe incorrect. Veuillez réessayer.";
            }
        } else {
            // Aucun utilisateur correspondant trouvé, afficher un message d'erreur
            echo " <br> Aucun utilisateur correspondant trouvé. Veuillez créer un compte.";
        }
    } else {
        // Gérer les erreurs liées à la requête
        echo "Erreur lors de la requête.";
    }
}




?>

<div class="container mt-5">
        <h1 class="text-center p-3 bg-primary text-white rounded">Connectez-vous</h1>
</div>

<div class="container mt-5">
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Se Connecter</button>
        </form>
    </div>


    <?php
include 'footer.php'; 
?>