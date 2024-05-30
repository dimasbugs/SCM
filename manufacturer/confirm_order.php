<?php
    error_reporting(0);

    require("../includes/config.php");
    session_start();

    // Check if the manufacturer is logged in
    if (isset($_SESSION['manufacturer_login'])) {
        $id = $_GET['id'];

        // Initialize variables for product IDs and quantities as empty arrays
        $orderProId = $orderQuantity = $availProId = $availQuantity = [];
        $queryAvailQuantity = "SELECT products.pro_id AS pro_id, products.quantity AS quantity FROM order_items, products WHERE products.pro_id = order_items.pro_id AND order_items.order_id = '$id' AND products.quantity IS NOT NULL";
        $resultAvailQuantity = mysqli_query($con, $queryAvailQuantity);
        $queryOrderQuantity = "SELECT quantity AS q, pro_id AS p FROM order_items WHERE order_id = '$id'";
        $resultOrderQuantity = mysqli_query($con, $queryOrderQuantity);
        while ($rowAvailQuantity = mysqli_fetch_array($resultAvailQuantity)) {
            $availProId[] = $rowAvailQuantity['pro_id'];
            $availQuantity[] = $rowAvailQuantity['quantity'];
        }

        while ($rowOrderQuantity = mysqli_fetch_array($resultOrderQuantity)) {
            $orderProId[] = $rowOrderQuantity['p'];
            $orderQuantity[] = $rowOrderQuantity['q'];
        }

        foreach (array_combine($orderProId, $orderQuantity) as $p => $q) {
            foreach (array_combine($availProId, $availQuantity) as $proId => $quantity) {
                if ($p == $proId) {
                    $total = $quantity - $q;
                    if ($total >= 0) {
                        $queryUpdateQuantity = "UPDATE products SET quantity='$total' WHERE pro_id='$proId'";
                        $result = mysqli_query($con, $queryUpdateQuantity);
                    }
                }
            }
        }

        // Check if the stock update was successful
        if (!isset($result) || !$result) {
            echo "<script> alert(\"Stok tidak mencukupi\"); </script>";
            header("refresh:0;url=view_orders.php");
        } else {
            // Confirm the order if stock update was successful
            $queryConfirm = "UPDATE orders SET approved=1 WHERE order_id='$id'";
            if (mysqli_query($con, $queryConfirm)) {
                echo "<script> alert(\"Pesanan berhasil dikonfirmasi\"); </script>";
                header("refresh:0;url=view_orders.php");
            } else {
                echo "<script> alert(\"Konfirmasi gagal.\"); </script>";
                header("refresh:0;url=view_orders.php");
            }
        }
    } else {
        // Redirect to the login page if not logged in
        header('Location:../index.php');
    }
?>
