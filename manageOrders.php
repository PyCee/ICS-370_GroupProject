<?php
    include("./force_login.php");
    global $user_id;
    include_once("./sqlInit.php");
    global $conn;
    include("./header.php");
?>


<!-- background on the website-->
<div class="bg">
    
    <?php
        if(isset($_POST["return_order_id"])){
            
            $query = "CALL `return_order`(".$_POST['return_order_id'].");";
            mysqli_multi_query($conn, $query) or die(mysqli_error($conn));
            $result = mysqli_store_result($conn);
            while (mysqli_next_result($conn));
            echo "<h4>Marked order #".$_POST["return_order_id"]." as returned</h4>";
        }
    ?>

    <h3>Manage Orders</h3>
    <?php 
        $query = "CALL `select_all_orders`()";
        mysqli_multi_query($conn, $query) or die(mysqli_error($conn));
        $result = mysqli_store_result($conn);
        $order_count = mysqli_num_rows($result);
        $order_ids = [];
        while($row = mysqli_fetch_row($result)){
            $order_ids[] = $row[0];
        }
        mysqli_free_result($result);
        while (mysqli_next_result($conn));

        if ($order_count == 0) {
            echo "<h3>No Orders in the system</h3>";
        } else {
            foreach($order_ids as $order_id){
                
                $query = "CALL `select_order_status`(".$order_id.");";
                mysqli_multi_query($conn, $query) or die(mysqli_error($conn));
                $result = mysqli_store_result($conn);
                $row = mysqli_fetch_row($result);
                $order_status = $row[0];
                mysqli_free_result($result);
                while (mysqli_next_result($conn));
                
                echo "<h3>Order ID: #".$order_id."</h3>";
                echo "<h3>Delivery Status: ".$order_status;
                if($order_status == 'delivered'){
                    echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
                    echo "<form action='' method='post'>
                            <button type='submit' name='return_order_id' value=".$order_id.">
                                Mark Order As Returned
                            </button>
                        </form>";
                }
                echo "</h3>";
                echo "<table><tr>
                <th>Item Name</th>
                <th>Item Quantity</th>
                <th>Item Price</th>";
                echo "</tr>";

                $query = "CALL `select_order_info`(".$order_id.");";
                mysqli_multi_query($conn, $query) or die(mysqli_error($conn));
                $result = mysqli_store_result($conn);
                while($row = mysqli_fetch_row($result)){
                    echo "<tr>";
                    echo "<td style='width: 250px;'>".$row[1]."</td>";
                    echo "<td style='width: 150px;'>".$row[2]."</td>";
                    echo "<td style='width: 100px;'>".$row[3]."</td>";
                    echo "</tr>";
                }
                mysqli_free_result($result);
                while (mysqli_next_result($conn));

                echo "</table><br><br>";
            }
        }
        
    ?>
    <br><br><br><br>
</div>
          
<?php
    include("./footer.php");
?>