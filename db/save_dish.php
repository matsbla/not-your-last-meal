<?php 

header( "refresh:5;url=../main.php" );

echo "The dish is added. You will be soon redirected to the main page...";
include_once 'upload_images.php';

 include_once "../objects/dish.php";
function makeDish() {
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
   {    
   $name = $_POST['title'];
   $presentation = $_POST['comment'];
   $ingredients = $_POST["Ingredients"];
   $country = $_POST['country'];
   $type = "lunch";
   $image = 'uploads/' . $_FILES["image"]["name"];

   $newDish = new Dish($name, $country, $ingredients, $presentation, $image, $type);
   return $newDish;
   }     

}
 $newDish = makeDish();
 $newDish->createInDatabase();

?>
