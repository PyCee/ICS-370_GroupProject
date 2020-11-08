<?php
    include("./force_login.php");
    global $user_id;
    include_once("./sqlInit.php");
    global $conn;
    include("./header.php");
?>

<div class="bg">
    <!-- background on the website-->

    <?php
    // Items
    if(isset($_POST['update']) && isset($_POST['item_id']) && 
    isset($_POST['name']) && isset($_POST['desc']) && 
    isset($_POST['price']) && isset($_POST['stock'])){
        // If this page was loaded to update an item
        $query = "CALL `update_available_item`(".$_POST['item_id'].", '".$_POST["name"]."', '".
            $_POST["desc"]."', ".$_POST['price'].", ".$_POST['stock'].");";
        mysqli_multi_query($conn, $query) or die(mysqli_error($conn));
        $result = mysqli_store_result($conn);
        while(mysqli_next_result($conn));
        echo "<h4>Updated Item: ".$_POST['name']."</h4>";

    } else if(isset ($_POST['delete']) && isset($_POST['item_id'])){
        // If this page was loaded to delete an item
        $query = "CALL `delete_available_item`(".$_POST['item_id'].");";
        mysqli_multi_query($conn, $query) or die(mysqli_error($conn));
        $result = mysqli_store_result($conn);
        while(mysqli_next_result($conn));
        echo "<h4>Deleted Item: ".$_POST['name']."</h4>";

    } else if(isset ($_POST['add']) && isset($_POST['name']) &&
    isset($_POST['desc']) && isset($_POST['price']) && 
    isset($_POST['stock'])){
        // If this page was loaded to add an item
        $query = "CALL `insert_new_available_item`('".$_POST["name"]."', '".
            $_POST["desc"]."', ".$_POST['price'].", ".$_POST['stock'].");";
        mysqli_multi_query($conn, $query) or die(mysqli_error($conn));
        $result = mysqli_store_result($conn);
        while(mysqli_next_result($conn));
        echo "<h4>Added Item: ".$_POST['name']."</h4>";
    } 
    
    // Materials
    else if(isset($_POST['update_mat']) && isset($_POST['mat_id']) && 
    isset($_POST['mat_name']) && isset($_POST['mat_qty']) && 
    isset($_POST['mat_units'])){
        // If this page was loaded to update a material
        $query = "CALL `update_material`(".$_POST['mat_id'].", '".$_POST["mat_name"]."', ".
            $_POST["mat_qty"].", '".$_POST['mat_units']."');";
        mysqli_multi_query($conn, $query) or die(mysqli_error($conn));
        $result = mysqli_store_result($conn);
        while(mysqli_next_result($conn));
        echo "<h4>Updated Material: ".$_POST['mat_name']."</h4>";

    } else if(isset ($_POST['delete_mat']) && isset($_POST['mat_id'])){
        // If this page was loaded to delete a material
        $query = "CALL `delete_material`(".$_POST['mat_id'].");";
        mysqli_multi_query($conn, $query) or die(mysqli_error($conn));
        $result = mysqli_store_result($conn);
        while(mysqli_next_result($conn));
        echo "<h4>Deleted Material: ".$_POST['mat_name']."</h4>";

    } else if(isset ($_POST['add_mat']) && isset($_POST['mat_name']) &&
    isset($_POST['mat_qty']) && isset($_POST['mat_units'])){
        // If this page was loaded to add a material
        $query = "CALL `insert_material`('".$_POST["mat_name"]."', ".
            $_POST["mat_qty"].", '".$_POST['mat_units']."');";
        mysqli_multi_query($conn, $query) or die(mysqli_error($conn));
        $result = mysqli_store_result($conn);
        while(mysqli_next_result($conn));
        echo "<h4>Added Material: ".$_POST['mat_name']."</h4>";
    }

    // Item-Material Relations
    else if(isset($_POST['update_relation']) && isset($_POST['relation_id']) && 
    isset($_POST['relation_qty'])){
        // If this page was loaded to update a relation
        $query = "CALL `update_order_item_relation`(".$_POST['relation_id'].", ".$_POST["relation_qty"].");";
        mysqli_multi_query($conn, $query) or die(mysqli_error($conn));
        $result = mysqli_store_result($conn);
        while(mysqli_next_result($conn));
        echo "<h4>Updated Relation.</h4>";

    } else if(isset ($_POST['delete_relation']) && isset($_POST['relation_id'])){
        // If this page was loaded to delete a relation
        $query = "CALL `delete_item_material_relation`(".$_POST['relation_id'].");";
        mysqli_multi_query($conn, $query) or die(mysqli_error($conn));
        $result = mysqli_store_result($conn);
        while(mysqli_next_result($conn));
        echo "<h4>Deleted Relation.</h4>";

    } else if(isset($_POST['relate_item_material']) && isset($_POST['item_id']) && 
    isset($_POST['material_id']) && isset($_POST['relation_qty'])){
        // If this page was loaded to add a relation
        $query = "CALL `relate_item_and_material`(".$_POST['item_id'].", ".$_POST['material_id'].", ".$_POST["relation_qty"].");";
        mysqli_multi_query($conn, $query) or die(mysqli_error($conn));
        $result = mysqli_store_result($conn);
        while(mysqli_next_result($conn));
        echo "<h4>Added Relation.</h4>";

    }
    ?>
    
    <h3>Edit Inventories</h3>
    <table><tr><th>Item Name</th><th>Description</th><th>Price</th><th>Qty</th>
    <?php
        $query = "CALL `select_all_items`()";
        mysqli_multi_query($conn, $query) or die(mysqli_error($conn));
        $result = mysqli_store_result($conn);
        while($row = mysqli_fetch_row($result)){
            $formID = "inventoryID" . $row[0];
            echo "<form id='".$formID."' action='./manageInventories.php' method='post'>
            <input type='hidden' id='item_id' name='item_id' value='".$row[0]."'>
            <tr>
                <td style='width: 150px;'>
                    <input type='text' id='name' name='name' value='".$row[1]."' required>
                </td>
                <td style='width: 250px;'>
                    <textarea id='desc' name='desc' form='".$formID."' required>".$row[2]."</textarea>
                </td>
                <td style='width: 50px;'>
                    <input type='text' id='price' name='price' value='".$row[3]."' required></td>
                <td>
                    <input style='width: 65px;'  min='0' max='999' type='number' name='stock' value='".$row[4]."' required>
                </td>
                <td>
                    <button type='submit' name='update' value=''>Update</button>
                </td>
                <td>
                    <button type='submit' name='delete' value=''>Delete</button>
                </td>
            </tr></form>";
        }
        mysqli_free_result($result);
        while (mysqli_next_result($conn));
    ?>
    </table><br>
    <h3>Edit Materials</h3>
    <table><tr><th>Material Name</th><th>Quantity</th><th>Units</th>
    <?php

        $query = "CALL `select_all_materials`()";
        mysqli_multi_query($conn, $query) or die(mysqli_error($conn));
        $result = mysqli_store_result($conn);
        while($row = mysqli_fetch_row($result)){
            $formID = "materialID" . $row[0];
            echo "<form id='".$formID."' action='./manageInventories.php' method='post'>
            <input type='hidden' id='mat_id' name='mat_id' value='".$row[0]."'>
            <tr>
                <td style='width: 150px;'>
                    <input type='text' id='name' name='mat_name' value='".$row[1]."' required>
                </td>
                <td>
                    <input style='width: 65px;'  min='0' max='999' type='number' name='mat_qty' value='".$row[2]."' required>
                </td>
                <td style='width: 150px;'>
                    <input type='text' id='units' name='mat_units' value='".$row[3]."' required>
                </td>
                <td>
                    <button type='submit' name='update_mat' value=''>Update</button>
                </td>
                <td>
                    <button type='submit' name='delete_mat' value=''>Delete</button>
                </td>
            </tr></form>";
        }
        mysqli_free_result($result);
        while (mysqli_next_result($conn));
    ?>
    </table><br>
    <div style="overflow: auto;">
        <div style="float:right;">
            <h3>Add New Item</h3>
            <form id='add_item_form_id' action='manageInventories.php' method='post'> <tr>
                <table>
                    <tr>
                        <td>Item Name</td>
                        <td><input type='text' name='name' required></td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td><textarea id='desc' name='desc' form='add_item_form_id' required></textarea></td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td><input type='text' name='price' required></td>
                    </tr>
                    <tr>
                        <td>Qty</td>
                        <td><input type='number' name='stock'  min='0' max='999' required></td>
                    </tr>
                </table>
                <button type='submit' name='add' value=''>Add Item</button></td>
            </form>
        </div>
        <div>
            <h3>Add New Material</h3>
            <form id='add_material_form_id' action='manageInventories.php' method='post'> <tr>
                <table>
                    <tr>
                        <td>Material Name</td>
                        <td><input type='text' name='mat_name' required></td>
                    </tr>
                    <tr>
                        <td>Quantity</td>
                        <td><input type='number' name='mat_qty' min='0' required></td>
                    </tr>
                    <tr>
                        <td>Units</td>
                        <td><input type='text' name='mat_units' required></td>
                    </tr>
                </table>
                <button type='submit' name='add_mat' value=''>Add Material</button></td>
            </form>
        </div>
    </div>
    <h3>Edit Item Material Relations</h3>
    <table><tr><th>Item Name</th><th>Material Name</th><th>Quantity</th>
    <?php

        $query = "CALL `select_all_item_material_info`()";
        mysqli_multi_query($conn, $query) or die(mysqli_error($conn));
        $result = mysqli_store_result($conn);
        while($row = mysqli_fetch_row($result)){
            $formID = "materialID" . $row[0];
            echo "<form id='".$formID."' action='./manageInventories.php' method='post'>
            <input type='hidden' id='relation_id' name='relation_id' value='".$row[0]."'>
            <tr>
                <td style='width: 250px;'>
                    ".$row[1]."
                </td>
                <td style='width: 150px;'>
                    ".$row[2]."
                </td>
                <td>
                    <input style='width: 65px;'  min='0' type='number' name='relation_qty' value='".$row[3]."' required>
                </td>
                <td>
                    <button type='submit' name='update_relation' value=''>Update</button>
                </td>
                <td>
                    <button type='submit' name='delete_relation' value=''>Delete</button>
                </td>
            </tr></form>";
        }
        mysqli_free_result($result);
        while (mysqli_next_result($conn));
        
    ?>
    </table><br>
    <h3>Relate Item and Material</h3>
            <form id='relate_material_form_id' action='manageInventories.php' method='post'> <tr>
                <table>
                    <tr>
                        <td>Item</td>
                        <td>
                        <select id="item_dropdown" name="item_id" required>
                            <?php
                                $query = "CALL `select_all_items`()";
                                mysqli_multi_query($conn, $query) or die(mysqli_error($conn));
                                $result = mysqli_store_result($conn);
                                while($row = mysqli_fetch_row($result)){
                                    echo "<option value='".$row[0]."'>".$row[1]."</option>";
                                }
                                mysqli_free_result($result);
                                while (mysqli_next_result($conn));
                            ?>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Material</td>
                        <td>
                        <select id="material_dropdown" name="material_id" required>
                            <?php
                                $query = "CALL `select_all_materials`()";
                                mysqli_multi_query($conn, $query) or die(mysqli_error($conn));
                                $result = mysqli_store_result($conn);
                                while($row = mysqli_fetch_row($result)){
                                    echo "<option value='".$row[0]."'>".$row[1]."</option>";
                                }
                                mysqli_free_result($result);
                                while (mysqli_next_result($conn));
                            ?>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Amount of Material</td>
                        <td><input type='number' name='relation_qty' min='0' required></td>
                    </tr>
                </table>
                <button type='submit' name='relate_item_material' value=''>Add Relation</button></td>
            </form>
</div>

<?php
    include("./footer.php");
?>