<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
if (!has_role("Admin")) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You don't have permission to access this page");
    die(header("Location: login.php"));
}
?>
    <h3>Create Incubator</h3>
    <form method="POST">
        <label>Name</label>
        <input name="name" placeholder="Name"/>
        <label>Quantity</label>
        <input type="number" name="base_rate"/>
        <label>Price</label>
        <input type="integer" name="mod_min"/>
        <label>Created</label>
        <input type="number" min="1" name="mod_max"/>
        <input type="submit" name="save" value="Create"/>
    </form>

<?php
if (isset($_POST["save"])) {
    //TODO add proper validation/checks
    $name = $_POST["name"];
    $br = $_POST["quantity"];
    $min = $_POST["price"];
    $max = $_POST["created"];
    $user = get_user_id();
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO Cart (name, quantity, price, created, user_id) VALUES(:name, :br, :min,:max,:user)");
    $r = $stmt->execute([
        ":name" => $name,
        ":br" => $br,
        ":min" => $min,
        ":max" => $max,
        ":user" => $user
    ]);
    if ($r) {
        flash("Created successfully with id: " . $db->lastInsertId());
    }
    else {
        $e = $stmt->errorInfo();
        flash("Error creating: " . var_export($e, true));
    }
}
?>
<?php require(__DIR__ . "/partials/flash.php");