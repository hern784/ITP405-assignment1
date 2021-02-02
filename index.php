<?php

require('./vendor/autoload.php');

// pgsql:host={host};port={port};dbname={dbname};user={user};password={password}

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}


$pdo = new PDO($_ENV['PDO_CONNECTION_STRING']);
$sql = "SELECT * FROM playlists";

$statement = $pdo->prepare($sql);
$statement->execute();
$playlists = $statement->fetchAll(PDO::FETCH_OBJ);

?>

<table>

    <thead>
        <tr>
            <th>PLAYLIST</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($playlists as $playlist) : ?>
            <tr>
                <td>
                    <form action="tracks.php" method="GET">
                        <input type="hidden" name="playlist_id" value="<?php echo $playlist->id ?>">
                        <input type="hidden" name="playlist_name" value="<?php echo $playlist->name ?>">
                        <button type="submit"><?php echo $playlist->name ?></button>
                    </form>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>


</table>
