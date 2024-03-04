<?php
include 'header.php';
include 'connexion.php';

// Traitement du formulaire de modification
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['id']) && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['date']) && isset($_POST['auteur'])) {
        // Récupérer les données soumises par le formulaire
        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $date = $_POST['date'];
        $auteur = $_POST['auteur'];
        $image_url = $_POST['image_url'];
        $archived = isset($_POST['archived']) ? 1 : 0;


        $sql = "UPDATE articles SET title = :title, content = :content, date = :date, auteur = :auteur, image_url = :image_url, archived = :archived WHERE id = :id";
        $result = $conn->prepare($sql);
        $result->bindValue(':id', $id);
        $result->bindValue(':title', $title);
        $result->bindValue(':content', $content);
        $result->bindValue(':date', $date);
        $result->bindValue(':auteur', $auteur);
        $result->bindValue(':image_url', $image_url);
        $result->bindValue(':archived', $archived, PDO::PARAM_INT);

        // Exécution de la requête
        if ($result->execute()) {
            echo "L'article a été modifié avec succès.";
        } else {
            echo "Une erreur s'est produite lors de la modification de l'article.";
        }
    } else {
        echo "Tous les champs du formulaire doivent être remplis.";
    }
}

// Affichage du formulaire de modification
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Requête SQL pour sélectionner les détails de l'article à modifier
    $sql = "SELECT * FROM articles WHERE id_articles = :id";
    $result = $conn->prepare($sql);
    $result->bindValue(':id', $id);
    $result->execute();
    $articles = $result->fetch(PDO::FETCH_ASSOC);
    
    // Vérifier si l'article existe
    if($articles) {
        ?>
        <div class="container mt-5">
        <h1 class="text-center p-3 bg-primary text-white rounded">Modifier l'article</h1>
        </div>
        <div class="container mt-5">
        <form action="edit.php" method="post">
            <?php echo "<p>ID de l'article : $id</p>" ?> 
            <input type="hidden" name="id" value="<?php echo $articles['id_articles']; ?>">

            <div class="form-group">
                <label for="title">Titre :</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $articles['title']; ?>" required>
            </div>

            <div class="form-group">
                <label for="content">Contenu :</label>
                <textarea class="form-control" id="content" name="content" rows="4" required><?php echo $articles['content']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="date">Date :</label>
                <input type="date" class="form-control" id="date" name="date" value="<?php echo $articles['date']; ?>" required>
            </div>

            <div class="form-group">
                <label for="auteur">Auteur :</label>
                <input type="text" class="form-control" id="auteur" name="auteur" value="<?php echo $articles['auteur']; ?>" required>
            </div>

            <div class="form-group">
                <label for="image_url">URL de l'image :</label>
                <input type="text" class="form-control" name="image_url">
            </div>

            <div class="form-check">
            <input type="checkbox" class="form-check-input" id="archived" name="archived" <?php echo (isset($articles['archived']) && $articles['archived']) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="archived">Archiver l'article</label>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Modifier</button>
        </form>
    </div>
        <?php
    } else {
        echo "L'article n'existe pas.";
    }
} else {
    // Requête SQL pour sélectionner la table "article"
    $sql = "SELECT * FROM articles";
    $result = $conn->prepare($sql);

    // Exécution de la requête
    $result->execute();

    // Récupération et affichage des données
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // Afficher chaque article avec un bouton "Modifier" pour le modifier
        echo '<div class="row">';
        echo '<div class="col-md-4">';
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<h2 class="card-title">' . $row['title'] . '</h2>';
        echo '<p class="card-text">' . $row['content'] . '</p>';

        if (!empty($row['image_url'])) {
            echo '<img src="' . $row['image_url'] . '" alt="Image de l\'article" style="max-width: 50%;">';
        }


        // Bouton de modification avec l'identifiant de l'article dans la requête GET
        echo '<a href="edit.php?id=' . $row['id_articles'] . '" class="btn btn-primary">Modifier</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

        
    }
}

include 'footer.php';
?>