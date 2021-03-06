<?php

class Dish {

  public $id, $name, $country, $ingredients, $presentation, $image, $type, $comments, $countryName;

  function __construct($name, $country, $ingredients, $presentation, $image, $type){

    $this->name = $name;
    $this->country = $country;
    $this->ingredients = $ingredients;
    $this->presentation = $presentation;
    $this->image = $image;
    $this->type = $type;
   // $this->comments = $comments;
  }

  function createInDatabase(){
    include_once("../db/db_init.php");
    include_once("../db/db_functions.php");

    $query = "INSERT INTO Dishes(DishID, DishName, CountryID, Presentation, Image, Type) VALUES (DEFAULT,'".$this->name."','".$this->country."','".$this->presentation."','".$this->image."','".$this->type."')";

    mysqli_query($link, $query);
    $dishes = listItems($link,"Dishes");
    //Finding User's ID
    foreach($dishes as $dish) {
      if($dish['DishName']==$this->name&&$dish['CountryID']==$this->country) {
        $this->id=$dish['DishID'];
        break;
      }
    }

    foreach($this->ingredients as $ingredient) {
       $query = "INSERT INTO ingredients_dishes(IngredientID, DishID) VALUES (".$ingredient.",".$this->id.")";
        mysqli_query($link, $query);
      }
  }

  function updateInDatabase(){
    // call to MYSQL file here
  }

  function deleteInDatabase(){
    // call to MYSQL file here
  }

  function addPost($post){
    // Add posts
  }

  function getPosts(){
    // Retrieve comments for node from database
  }

  function getTeaser(){
    return "
      <a class=\"dish-teaser-wrapper\" href=\"dishes.php?selectedDish=$this->id\">
      <div class=\"dish-teaser\">
        <div class=\"dish-image\"><img src=\"$this->image\"></div>
        <h2 class=\"dish-name\"> $this->name </h2>
      </div>
      </a>
    ";
  }

  function getContent(){
    include_once("../db/db_init.php");

    include_once("../db/db_functions.php");
   // Make a string with list of alergies
   if($this->ingredients != null){
      $ingredients;
      foreach($this->ingredients as $value){
        $ingredients .= $value["IngredientName"] . ', ';
      }
   }

    return "
      <div class=\"dish-content\">
           <title>$this->name</title>
           <h2 class=\"dish-name\">$this->name</h2>
           <div class=\"dish-picture\"><img src=\"$this->image\" alt=\"$this->image\"></div>
           <div class=\"dish-type\"><b>Type:</b> $this->type</div>
           <div class=\"dish-ingrediences\"><b>Ingredients:</b> $ingredients</div>
           <div class=\"dish-presentation\"><b>About:</b> $this->presentation</div>
      </div>
    ";
  }



}

function createFromDatabase($link, $dish) {
    include_once("..db/db_functions.php");
    $query = "SELECT Ingredients.IngredientName, ingredients_dishes.IngredientID
      FROM ingredients_dishes
      INNER JOIN Ingredients
      ON Ingredients.IngredientID=ingredients_dishes.IngredientID
      WHERE ingredients_dishes.DishID=".$dish['DishID'];
    $result = mysqli_query($link, $query);
    if (!$result)
    {
      echo "no result from query ";
      $error = 'Error fetching ingredients_dishes: ' . mysqli_error($link);
      include '../db/error.html.php';
      exit();
    }

    while ($row = mysqli_fetch_array($result))
    {
      $ingredients[] = $row;

    }
    // $countryName = itemByID($link, "Countries", "CountryName",$dish["CountryID"], "CountryID");
   // echo $countryName;
    $newDish = new Dish($dish['DishName'], $dish['CountryID'], $ingredients ,$dish['Presentation'], $dish['Image'], $dish['Type']);
    $newDish->id = $dish["DishID"];
    $newDish->countryName;
    return $newDish;
  }

  function findByID($id, $dishList) {
    foreach ($dishList as $dish) {
      if ($dish->id==$id) {
        return $dish;
      }
    }

  }
  function filterByCountry($CountryID, $dishList) {
    $filteredDishes = array();
    foreach ($dishList as $dish) {
      if ($dish->country==$CountryID) {
        $filteredDishes[] = $dish;
      }
    }
      return $filteredDishes;
  
}

function filterByAllergies($allergies, $dishList) {
  $filteredDishes = array();
  $allergic = false;
  $allergiesID = array_column($allergies, "IngredientID"); 
  foreach ($dishList as $dish) {
    $ingredientsID = array_column($dish->ingredients, "IngredientID");
    foreach ($allergiesID as $allergyID) {
      if(in_array($allergyID, $ingredientsID)) {
        $allergic = true;
        break;
      }
    }
    if($allergic){
      $allergic = false;
    } else {
      $filteredDishes[] = $dish;
    }
  }
  return $filteredDishes;
  
}
