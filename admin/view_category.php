<?php
	include("../includes/config.php");
	session_start();
	if(isset($_SESSION['admin_login'])) {
		if($_SESSION['admin_login'] == true) {
			$query_selectCategory = "SELECT * FROM categories";
			$result_selectCategory = mysqli_query($con,$query_selectCategory);
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				if(isset($_POST['chkId'])) {
					$chkId = $_POST['chkId'];
					foreach($chkId as $id) {
						$query_deleteCategory = "DELETE FROM categories WHERE cat_id='$id'";
						$result = mysqli_query($con,$query_deleteCategory);
					}
					if(!$result) {
						echo "<script> alert(\"Tidak dapat menghapus kategori yang terpakai\"); </script>";
						header('Refresh:0');
					}
					else {
						echo "<script> alert(\"Kategori dihapus \"); </script>";
						header('Refresh:0');
					}
				}
			}
		}
		else {
			header('Location:../index.php');
		}
	}
	else {
		header('Location:../index.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title> Lihat Kategori </title>
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
		include("../includes/nav_admin.inc.php");
		include("../includes/aside_admin.inc.php");
	?>
	<section>
		<h1>Lihat Kategori</h1>
		<form action="" method="POST" class="form">
		<table class="table_displayData">
			<tr>
				<th> <input type="checkbox" onClick="toggle(this)" /> </th>
				<th>Sr. No.</th>
				<th>Nama</th>
				<th>Deskripsi</th>
				<th> Edit </th>
			</tr>
			<?php $i=1; while($row_selectCategory = mysqli_fetch_array($result_selectCategory)) { ?>
			<tr>
				<td> <input type="checkbox" name="chkId[]" value="<?php echo $row_selectCategory['cat_id']; ?>" /> </td>
				<td> <?php echo $i; ?> </td>
				<td> <?php echo $row_selectCategory['cat_name']; ?> </td>
				<td> <?php echo $row_selectCategory['cat_details']; ?> </td>
				<td> <a href="edit_category.php?id=<?php echo $row_selectCategory['cat_id']; ?>"><img src="../images/edit.png" alt="edit" /></a> </td>
			</tr>
			<?php $i++; } ?>
		</table>
		<input type="submit" value="Hapus" class="submit_button"/>
		<a href="add_category.php"><input type="button" value="+ Tambah Kategori" class="submit_button"/></a>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>