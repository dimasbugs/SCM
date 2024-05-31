<?php
	include("../includes/config.php");
	session_start();
	if(isset($_SESSION['manufacturer_login'])) {
			$query_selectProducts = "SELECT * FROM products,categories,unit WHERE products.pro_cat=categories.cat_id AND products.unit=unit.id ORDER BY pro_id";
			$result_selectProducts = mysqli_query($con,$query_selectProducts);
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				if(isset($_POST['chkId'])) {
					$chkId = $_POST['chkId'];
					foreach($chkId as $id) {
						$query_deleteProduct = "DELETE FROM products WHERE pro_id='$id'";
						$result = mysqli_query($con,$query_deleteProduct);
					}
					if(!$result) {
						echo "<script> alert(\"Tidak dapat menghapus produk yang telah dipesan\"); </script>";
						header('Refresh:0');
					}
					else {
						echo "<script> alert(\"Produk Berhasil Dihapus!\"); </script>";
						header('Refresh:0');
					}
				}
			}
		}
		else {
			header('Location:../index.php');
		}
?>
<!DOCTYPE html>
<html>
<head>
	<title> Lihat Produk </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
	<script language="JavaScript">
	function toggle(source) {
		checkboxes = document.getElementsByName('chkId[]');
		for(var i=0, n=checkboxes.length;i<n;i++) {
			checkboxes[i].checked = source.checked;
		}
	}
	</script>
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_manufacturer.inc.php");
		include("../includes/aside_manufacturer.inc.php");
	?>
	<section>
		<h1>Lihat Produk</h1>
		<form action="" method="POST" class="form">
		<table class="table_displayData">
			<tr>
				<th> <input type="checkbox" onClick="toggle(this)" /> </th>
				<th> Kode </th>
				<th> Nama </th>
				<th> Harga </th>
				<th> Unit </th>
				<th> Kategori </th>
				<th> Kuantitas </th>
				<th> Edit </th>
			</tr>
			<?php $i=1; while($row_selectProducts = mysqli_fetch_array($result_selectProducts)) { ?>
			<tr>
				<td> <input type="checkbox" name="chkId[]" value="<?php echo $row_selectProducts['pro_id']; ?>" /> </td>
				<td> <?php echo $row_selectProducts['pro_id']; ?> </td>
				<td> <?php echo $row_selectProducts['pro_name']; ?> </td>
				<td> <?php echo $row_selectProducts['pro_price']; ?> </td>
				<td> <?php echo $row_selectProducts['unit_name']; ?> </td>
				<td> <?php echo $row_selectProducts['cat_name']; ?> </td>
				<td> <?php if($row_selectProducts['quantity'] == NULL){ echo "N/A";} else {echo $row_selectProducts['quantity'];} ?> </td>
				<td> <a href="edit_product.php?id=<?php echo $row_selectProducts['pro_id']; ?>"><img src="../images/edit.png" alt="edit" /></a> </td>
			</tr>
			<?php $i++; } ?>
		</table>
		<input type="submit" value="Hapus" class="submit_button"/>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>