<?php
include('header.php');
include('connexion.php');

// Avant de faire une requête SQL pour sélectionner les articles
$sql = "SELECT * FROM articles WHERE archived = 0 ORDER BY date DESC";
$result = $conn->query($sql);
$result->execute();

?>

<div class="container mt-5">
    <h1 class="text-center p-3 bg-primary text-white rounded">Journal Technologique</h1>
    <p class="text-center mt-3">Bienvenue sur le site du Journal Technologique. Découvrez les dernières actualités et innovations technologiques. Un journal technologique est une plateforme spécialisée qui couvre les avancées, les tendances et les développements dans le domaine de la technologie, offrant des insights sur les nouvelles inventions, les gadgets émergents, et bien plus encore.</p>
</div>
<h2 class="text-center p-1 bg-info text-white rounded">Articles</h2>

<ul>
    <?php
    // Utiliser une variable distincte pour stocker les résultats
    $articlesToShow = $result->fetchAll(PDO::FETCH_ASSOC);

    foreach ($articlesToShow as $row) {
        echo "<li>";
        echo "<strong>" . $row['title'] . "</strong><br>";
        echo $row['content'] . "<br>";
        echo "<small>Créé le " . $row['date'] . " par " . $row['auteur'] . "</small>";

        // Afficher l'image si elle existe
        if (!empty($row['image_url'])) {
            echo "<img src='" . $row['image_url'] . "' alt='Image de l'article'>";
        }

        echo "</li>";
    }
    ?>
</ul>

<!-- Ajouter un champ de recherche -->
<div class="container mt-5">
        <form action="index.php" method="get" class="form-inline">
            <div class="form-group">
                <label for="search" class= "mr-2">Rechercher des articles :</label>
                <input type="text" name="search" class="form-control mr-2" placeholder="Entrez votre recherche">
            </div>
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </form>
    </div>
<?php
if (isset($_GET['search'])) {
    $search_term = $_GET['search'];
    $sql = "SELECT * FROM articles WHERE title LIKE :search OR content LIKE :search ORDER BY date DESC";
    $result = $conn->prepare($sql);
    $result->bindValue(':search', '%' . $search_term . '%', PDO::PARAM_STR);
    $result->execute();
    $searchResults = $result->fetchAll(PDO::FETCH_ASSOC);

    // Utiliser la nouvelle variable pour afficher les résultats de la recherche
    foreach ($searchResults as $row) {
        echo "<li>";
        echo "<strong>" . $row['title'] . "</strong><br>";
        echo $row['content'] . "<br>";
        echo "<small>Créé le " . $row['date'] . " par " . $row['auteur'] . "</small>";

        // Afficher l'image si elle existe
        if (!empty($row['image_url'])) {
            echo "<img src='" . $row['image_url'] . "' alt='Image de l'article'>";
        }

        echo "</li>";
    }
}

include('footer.php');
?>