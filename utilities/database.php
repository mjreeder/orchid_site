$database = new PDO('pgsql:host=localhost;dbname=orchid', "root", "root", array(
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
));
<!-- $statement = $database->prepare("SELECT * FROM whatever WHERE something = ?");
$statement->execute(array("value"))

$statement->rowCount();//get number of rows

$statement->fetch(PDO::FETCH_ASSOC);

while($row = $statement->fetch(PDO::FETCH_ASSOC)){

}

$database->lastInsertId(): -->
