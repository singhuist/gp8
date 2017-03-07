<?php
require_once(__DIR__ . "database.php");
require_once(__DIR__ . "user.php");

$dbconnection = Database::getConnection();

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    $keywords = isset($_GET["keywords"]) ? explode(" ", $_GET["keywords"]) : array();
    $location = isset($_GET["location"]) ? $_GET["location"] : "";
    $flags = isset($_GET["flags"]) ? intval($_GET["flags"]) : 0;
    $description = isset($_GET["description"]) ? $_GET["description"] : "";

    $location = mysqli_real_escape_string($dbconnection, $location);
    $description = mysqli_real_escape_string($dbconnection, $description);

    $sql = "SELECT title,description,location,flags,posttime,expiry FROM PostsTable";
    if (sizeof($keywords != 0))
    {
        $filtered = mysqli_real_escape_string($dbconnection, $keywords[0]);
        $sql .= " WHERE description LIKE %" . $filtered . "% OR title LIKE %" . $filtered . "%";
        for ($i = 1; $i < sizeof($keywords); $i++)
        {
            $filtered = mysqli_real_escape_string($dbconnection, $keywords[$i]);
            $sql .= " OR description LIKE %" . $filtered . "% OR title LIKE %" . $filtered . "%";
        }
    }

    $result = $dbconnection->query($sql);

    $out = array();
    $uflags = $_SESSION["user"]->getFlags();
    while ($row = mysqli_fetch_array($result))
    {
        if (areCompatible($uflags, intval($row["flags"]))) $out[] = $row;
    }
    echo json_encode($out);
}
?>