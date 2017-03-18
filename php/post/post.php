<?php
require_once(__DIR__ . "/../database.php");
require_once(__DIR__ . "/../user.php");
cSessionStart();
if (!loginCheck())
{
    header("Location: index.php");
    exit;
}?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "post" action="post.php" id="newpost">
<h3>Post a new item</h3>
<p>
<p>
Title: <input type="text" name="title"><br><br>
Description: <input type="text" name="description"><br><br>
Flags (Check all that apply):
<br>
Vegan? <input type="checkbox" name="flags[]" value="VEGAN" <?php echo ($_SESSION["user"]->checkFlag(VEGAN) ? "checked" : "");?>>
Vegetarian? <input type="checkbox" name="flags[]" value="VEGETARIAN" <?php echo ($_SESSION["user"]->checkFlag(VEGETATIAN) ? "checked" : "");?>><br/>
Peanuts? <input type="checkbox" name="flags[]" value="PEANUT" <?php echo ($_SESSION["user"]->checkFlag(PEANUT) ? "checked" : "");?>>
Soy? <input type="checkbox" name="flags[]" value="SOY" <?php echo ($_SESSION["user"]->checkFlag(SOY) ? "checked" : "");?>><br/>
Gluten? <input type="checkbox" name="flags[]" value="GLUTEN" <?php echo ($_SESSION["user"]->checkFlag(GLUTEN) ? "checked" : "");?>>
Lactose? <input type="checkbox" name="flags[]" value="LACTOSE" <?php echo ($_SESSION["user"]->checkFlag(LACTOSE) ? "checked" : "");?>><br/>
Halal? <input type="checkbox" name="flags[]" value="HALAL" <?php echo ($_SESSION["user"]->checkFlag(HALAL) ? "checked" : "");?>>
Kosher? <input type="checkbox" name="flags[]" value="KOSHER" <?php echo ($_SESSION["user"]->checkFlag(KOSHER) ? "checked" : "");?>><br/>
<br>
<br>
Expiry date: <input type="date" name="expiry"><br><br>
Upload Image: <input type="image" name="food_image" id="upload_image"><br><br>
<input type="submit" value="Upload Image" name="submit"><br<br>
<button type="submit">Post</button>
</form>
<input id="addressInput" class="controls" type="text" placeholder="Search...">
<div id="inputMap" style="width: 500px; height: 500px;"></div>
<script src="../../bootstrap-material-design/js/jquery-3.1.1.min.js"></script>
<script src="../../js/enterLocation.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIMtO0_uKM_0og7IjdV7nBDjH4dtUmVoY&callback=initMap&libraries=places" async defer></script>

<?php
/*
 * If 'id' is set, this file will either update that post or delete it (if 'delete' is set)
 * Otherwise it creates a new post.
 */


$_POST = array();
parse_str(file_get_contents('php://input'), $_POST);

$dbconnection = Database::getConnection();
//todo test this
if (isset($_POST["id"]))
{
    $postID = intval($_POST["id"]);
    $stmt = $dbconnection->prepare("SELECT title, description, location, flags, userid, expiry FROM PostsTable WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $postID);
    $stmt->bind_result($title, $description, $location, $flags, $userid, $expiry);
    $stmt->execute();
    $stmt->store_result();
    $stmt->fetch();
    if ($userid === $_SESSION["user"]->getUserID() && $stmt->num_rows == 1)
    {
        if (isset($_POST["delete"]))
        {
            if (!$dbconnection->query("DELETE FROM POSTSTABLE WHERE id = " . $postID))
            {
                echo ($dbconnection->error);
            }
        }
        else
        {
            $title = (isset($_POST["title"])) ? $_POST["title"] : $title;
            $description = (isset($_POST["description"])) ? $_POST["description"] : $description;
            $location = (isset($_POST["location"])) ? $_POST["location"] : $location;
            $expiry = (isset($_POST["expiry"])) ? $_POST["expiry"] : $expiry;

            if (is_array($_POST["flags"]))
            {
                $flags = 0;
                foreach ($_POST["flags"] as $value) $flags |= constant($value);
            }

            $stmt = $dbconnection->prepare("UPDATE PostsTable SET title=?, description=?, location=?, posttime=now(), expiry=?, flags=? WHERE id=?");
            $stmt->bind_param("ssssii", $title, $description, $location, $expiry, $flags, $postID);
            if (!$stmt->execute()) echo $dbconnection->error;
        }
    }
}

else if (isset($_POST["title"]))
{
    $dbconnection = Database::getConnection();

    $flags = 0;
    if (is_array($_POST["flags"]))
    {
        foreach ($_POST["flags"] as $value) $flags |= constant($value);
    }

    $stmt = $dbconnection->prepare("INSERT INTO PostsTable (title, description, expiry, flags, userid) VALUES (?, ?, ?, ?, ?)");
    $title = $_POST["title"];
    $descrip =  $_POST["description"];
    $userid = $_SESSION["user"]->getUserID();
    $date = date('m/d/Y', strtotime($_POST["expiry"]));
    $stmt->bind_param("sssii", $title, $descrip, $date, $flags, $userid);
    if ($stmt->execute())
    {
        if ($stmt->affected_rows === 1) echo("Your item has been posted");
        else echo("No post made");
    }
    else echo("Post failed");
}

/*TODO paste this into listing page
$postID = intval($_GET["id"]);
$stmt = $dbconnection->prepare("SELECT title, description, location, flags, userid, posttime, expiry FROM PostsTable WHERE id=? LIMIT 1");
$stmt->bind_param("i", $postID);
$stmt->bind_result($title, $description, $location, $flags, $hisID, $time, $expiry);
$stmt->execute();
$stmt->store_result();
$stmt->fetch();
$otherName = $_SESSION["user"]->idToName($hisID); */
?>