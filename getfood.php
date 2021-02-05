<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("db_config.php");
global $connection;

$sql = "SELECT food_id,food_name, image, restaurant FROM foods WHERE food_id = ?";

$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $_GET['q']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($food_id,$food_name, $image, $restaurant);
$stmt->fetch();
$stmt->close();

echo ' <table class="table table-striped"><thead>
                    <tr>
                        <th scope="col" width="40%">Étel</th>
                        <th scope="col" width="30%">Étterem</th>
                        <th scope="col" width="30%">Kép</th>
                       
                    </tr>
                    </thead>
                    <tbody>';
echo '<tr>
<td>'.$food_name.'</td>
<td>'.$restaurant.'</td>
<td><img src="pictures/'.$image.'" alt="'.$food_name.'" width="80px" height="80px"></td>

</tr>';


echo '</tbody></table>';
?>
<form method="POST" action="LogedIn.php">
    <input type="hidden" name="name" value="<?php echo $food_name?>">
    <input type="hidden" name="restaurant" value="<?php echo $restaurant?>">
    <input type="hidden" name="id" value="<?php echo $food_id?>">
    <label for="comment">Vélemény:</label><br>
    <textarea name="comment"></textarea><br>
    <label for="mark">Jegy:</label>
    <input name="mark" type="number" min="1" max="5"><br>
    <button type="submit" name="add" value="<?php echo $food_id?>" class="btn btn-warning mt-1">Hozzáad</button>
</form>