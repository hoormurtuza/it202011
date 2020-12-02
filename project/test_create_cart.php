<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
if (!has_role("Admin")) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You don't have permission to access this page");
    die(header("Location: login.php"));
}
?>
    <h3>Create Cart</h3>
    <form method="POST">
        <label>product_id</label>
        <input type="int" name="product_id"/>
	<label>Quantity</label>
        <input type="number" min="1" name="quantity"/>


        <input type="submit" name="save" value="Create"/>
    </form>

<?php
if (isset($_POST["save"])) {
    //TODO add proper validation/checks
    $product_id = ("SELECT Products.name FROM Products JOIN Cart on F20_Products.id = Cart.product_id WHERE Cart.user_id = :id");
    $quantity = $_POST["quantity"];

    $db = getDB();
    $stmt = $db->prepare("INSERT INTO Cart (product_id, quantity) VALUES(:name, :quantity)");
    $r = $stmt->execute([
        ":product_id" => $product_id,
        ":quantity" => $quantity,

        
    ]);
    if ($r) {
        flash("
        
        d successfully with id: " . $db->lastInsertId());
    }
    else {
        $e = $stmt->errorInfo();
        flash("Error creating: " . var_export($e, true));
    }
}
?>
<?php require(__DIR__ . "/partials/flash.php");