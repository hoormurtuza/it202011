<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
if (!has_role("Admin")) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You don't have permission to access this page");
    die(header("Location: login.php"));
}
?>

<form method="POST">
	<label>Name</label>
	<input name="name"/>
	<label>Quantity</label>
	<input type="int" min="1" name="quantity"/>
	<label>Price</label>
	<input type="decimal" min="1" name="price"/>
	<label>Description</label>
	<input type="text" min="1" name="description"/>
	<input type="submit" name="save" value="Create"/>
</form>

<?php
if(isset($_POST["save"])){
	//TODO add proper validation/checks
	$name = $_POST["name"];
	$quantity = $_POST["quantity"];
	$br = $_POST["price"];
	$min = $_POST["description"];
	$max = date('Y-m-d H:i:s');
	$nst = date('Y-m-d H:i:s');//calc

	$db = getDB();
	$stmt = $db->prepare("INSERT INTO F20_Products (name, quantity, price, description, modified, created) VALUES(:name, :quantity, :br, :min, :max, :nst)");
	$r = $stmt->execute([
		":name"=>$name,
		":quantity"=>$quantity,
		":br"=>$br,
		":min"=>$min,
		"max"=>$max,
		":nst"=>$nst,

	]);
	if($r){
		flash("Created successfully with id: " . $db->lastInsertId());
	}
	else{
		$e = $stmt->errorInfo();
		flash("Error creating: " . var_export($e, true));
	}
}
?>
<?php require(__DIR__ . "/partials/flash.php");
