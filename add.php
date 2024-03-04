<?php 
include('connexion.php');
include('header.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $date = $_POST['date'];
    $auteur = $_POST['auteur'];
    $image_url = $_POST['image_url'];

    $image_url = filter_var($image_url, FILTER_SANITIZE_URL);

  

    $sql = "INSERT INTO articles (title, content, date, auteur, image_url) VALUES (:title, :content, :date, :auteur, :image_url)";
    $result = $conn->prepare($sql);
    $result->bindValue(':title', $title);
    $result->bindValue(':content', $content);
    $result->bindValue(':date', $date);
    $result->bindValue(':auteur', $auteur);
    $result->bindValue(':image_url', $image_url);

    // Exécuter la requête SQL
    if ($result->execute()) {
        // Rediriger l'utilisateur vers une page de succès
        echo "  Article reçu dans la base de données";
    } else {
        // Afficher un message d'erreur en cas d'échec de l'insertion
        echo "  L'article n'est pas dans la base de données";
    }
    
    
    
}


?>

    <h2 class="text-center p-3 bg-primary text-white rounded">Publier un Article</h2>

    <div class="container mt-5">
        <form action="add.php" method="post">
            <div class="form-group">
                <label for="title">Titre :</label>
                <input type="text" class="form-control" name="title" id="title" required>
            </div>
            <div class="form-group">
                <label for="content">Contenu :</label>
                <input type="text" class="form-control" name="content" id="content" required>
            </div>
            <div class="form-group">
                <label for="date">Date de création :</label>
                <input type="date" class="form-control" name="date" id="date" required>
            </div>
            <div class="form-group">
                <label for="user">Utilisateur :</label>
                <input type="text" class="form-control" name="auteur" id="auteur" required>
            </div>
            <div class="form-group">
                <label for="image_url">URL de l'image :</label>
                <input type="text" class="form-control" name="image_url">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
    

<?php
include('footer.php');
?> 