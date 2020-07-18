<?php
include("header.php");
?>

<?php
$search = "";
if(isset($_POST["search"])){
    $search = $_POST["search"];
}
?>
<form method="POST">
    <input type="text" name="search" placeholder="Search Products"
           value="<?php echo $search;?>"/>
    <input type="radio" name='button' value="search" id="1">
    <label for="Search">Search</label>
    <input type="radio" name='button' value='ascend' id="2">
    <label for="Ascending Order">Ascending Order</label>
    <input type="radio" name='button' value='descend' id="3">
    <label for="Descending Order">Descending Order</label>
    <input type="submit" value="Submit"/>
</form>

<?php
if($_POST["button"] == "ascend"){
    require("common.inc.php");
    $query = file_get_contents(__DIR__ . "/queries/ASCEND_TABLE_PRODUCTS.sql");

    try {
        $stmt = getDB()->prepare($query);
        $stmt->execute([":product"=>$search]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
elseif($_POST["button"] == "descend"){
    require("common.inc.php");
    $query = file_get_contents(__DIR__ . "/queries/DESCEND_TABLE_PRODUCTS.sql");

    try {
        $stmt = getDB()->prepare($query);
        $stmt->execute([":product"=>$search]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
elseif($_POST["button"] == "search"){

    require("common.inc.php");
    $query = file_get_contents(__DIR__ . "/queries/SEARCH_TABLE_PRODUCTS.sql");
    if (isset($query) && !empty($query)) {
        try {
            $stmt = getDB()->prepare($query);
            //Note: With a LIKE query, we must pass the % during the mapping
            $stmt->execute([":product"=>$search]);
            //Note the fetchAll(), we need to use it over fetch() if we expect >1 record
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>
<!--This part will introduce us to PHP templating,
note the structure and the ":" -->
<!-- note how we must close each check we're doing as well-->
<?php if(isset($results) && count($results) > 0):?>
    <p>This shows when we have results</p>
    <ul>
        <!-- Here we'll loop over all our results and reuse a specific template for each iteration,
        we're also using our helper function to safely return a value based on our key/column name.-->
        <?php foreach($results as $row):?>
            <li>
                <?php echo get($row, "product")?>
                <?php echo get($row, "price");?>
                <?php echo get($row, "quantity");?>
                <a href="delete.php?thingId=<?php echo get($row, "id");?>">Delete</a>
            </li>
        <?php endforeach;?>
    </ul>
<?php else:?>
    <p>This shows when we don't have results</p>
<?php endif;?>