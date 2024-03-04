<?php
// Inclure le fichier de connexion à la base de données
include 'header.php';
include 'connexion.php';

// Vérifier si la requête est une requête POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données soumises par le formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $password = $_POST["password"];
   
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Requête SQL pour insérer l'article dans la base de données
    $sql = "INSERT INTO utilisateurs ( nom, prenom, email, password) VALUES (:nom, :prenom, :email, :hashed_password)";
    $result = $conn->prepare($sql);
    $result->bindValue(':nom', $nom);
    $result->bindValue(':prenom', $prenom);
    $result->bindValue(':email', $email);
    $result->bindValue(':hashed_password', $hashed_password);
    
    

    // Exécuter la requête SQL
    if ($result->execute()) {
        // Rediriger l'utilisateur vers une page de succès
        echo "Compte créer";
        header("Location: login.php");
    } else {
        // Afficher un message d'erreur en cas d'échec de l'insertion
        echo "Erreur lors de la création du compte";
    }
}
?>


<div class="container mt-5">
        <h1 class="text-center p-3 bg-primary text-white rounded">Créer son compte</h1>
    </div>
    <div class="container mt-5">
        <form action="newcompte.php" method="post">
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password :</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>

<?php   
include 'footer.php';
?>