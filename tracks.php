<?php

require('./vendor/autoload.php');

// pgsql:host={host};port={port};dbname={dbname};user={user};password={password}

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

if (!isset($_GET['playlist_id'])) {
    header("Location: ./index.php");
}

$id = $_GET['playlist_id'];
$name = $_GET['playlist_name'];

$pdo = new PDO($_ENV['PDO_CONNECTION_STRING']);
$sql = "SELECT tracks.name, albums.title, tracks.composer AS artist, tracks.unit_price AS price, genres.name AS genre FROM playlist_track
        LEFT join tracks
        ON playlist_track.track_id=tracks.id
        INNER join albums
        ON tracks.album_id=albums.id
        INNER join genres
        ON tracks.genre_id=genres.id
        WHERE playlist_id= " . $id . ";";

$statement = $pdo->prepare($sql);
$statement->execute();
$tracks = $statement->fetchAll(PDO::FETCH_OBJ);

?>


<table>

    <?php if (count($tracks) > 0) : ?>
        <thead>
            <tr>
                <td>Track Name</td>
                <td>Album Title</td>
                <td>Artist Name</td>
                <td>Price</td>
                <td>Genre Name</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tracks as $track) : ?>
                <tr>
                    <td><?php echo $track->name ?></td>
                    <td><?php echo $track->title ?></td>
                    <td><?php echo $track->artist ?></td>
                    <td><?php echo $track->price ?></td>
                    <td><?php echo $track->genre ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    <?php else : ?>
        <p>No tracks found for <?php echo $name ?></p>
    <?php endif; ?>

</table>
