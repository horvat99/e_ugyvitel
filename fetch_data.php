<?php

include('database_connection.php');
global $connect;
if(isset($_POST["action"]))
{
    $query = "
		SELECT * FROM foods WHERE product_status = '1'
	";
    if(isset($_POST["postcode"]))
    {
        $postcode_filter = implode("','", $_POST["postcode"]);
        $query .= "
		 AND postcode IN('".$postcode_filter."')
		";
    }
    if(isset($_POST["type"]))
    {
        $type_filter = implode("','", $_POST["type"]);
        $query .= "
		 AND type IN('".$type_filter."')
		";
    }
    if(isset($_POST["restaurant"]))
    {
        $restaurant_filter = implode("','", $_POST["restaurant"]);
        $query .= "
		 AND restaurant IN('".$restaurant_filter."')
		";
    }

    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $total_row = $statement->rowCount();
    $output = '';
    if($total_row > 0)
    {
        echo '<table class="table table-striped w-100">
                <thead>
                <tr>
                    <th scope="col">Kép</th>
                    <th scope="col">Név</th>
                    <th scope="col">Jegy</th>
                    <th scope="col">Leírás</th>
                    <th scope="col">Étterem</th>
                    <th scope="col">Város</th>
                    <th scope="col">Ár</th>
                    <th scope="col">Mennyiség</th>
                    <th scope="col">Kosár</th>
                </tr>
                </thead>
                <tbody>';
        foreach($result as $row)
        {
            $id = $row['food_id'];
            $stmtAvg = $connect->prepare("SELECT AVG(mark) AS avgMark FROM comments WHERE food_id ='$id'");
            $stmtAvg ->execute();
            $avg = $stmtAvg->fetchAll();
            $postcode = $row['postcode'];
            $stmt = $connect->prepare("SELECT DISTINCT city from city where postcode='$postcode'");
            $stmt->execute();
            $city = $stmt->fetchAll();
            //echo $city[0]['city'];

            $output.= '
           
		
				<tr><td style="max-width: 70px;">
					<img src="pictures/'. $row['image'] .'" alt="" width="100px" height="100px" class="img-fluid">

					</td>
					<td style="max-width: 100px;">'.$row['food_name'].'</td>
					<td style="max-width: 80px;">'.$avg[0]["avgMark"].'</td>
					<td style="max-width: 150px;">'.$row['description'].'</td>
					<td style="max-width: 100px;">'.$row['restaurant'].'</td>
					<td style="max-width: 100px;">'.$city[0]['city'].'</td>
					<td style="max-width: 70px;;">'.$row['price'].' rsd</td>
					<td><input type="number" name="quantity" style="max-width: 80px" id="quantity' . $row["food_id"] .'" min="1" value="1"></td>
                  	<input type="hidden" name="hidden_name" id="name'.$row['food_id'].'" value="'.$row['food_name'].'" />
            	    <input type="hidden" name="hidden_price" id="price'.$row['food_id'].'" value="'.$row['price'].'" />
					<td><button name="add_to_cart" id="'.$row['food_id'].'" class="btn btn-warning border border-dark add_to_cart"><i class="fas fa-shopping-cart"></i></button></td>
					</tr>
			

		
		
			';
        }
    }
    else
    {
        echo '<h3>Nincs találat. <i class="fas fa-frown"></i></h3>';
    }
    echo $output;
}

?>