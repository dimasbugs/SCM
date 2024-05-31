<?php
	error_reporting(0);
	require("../includes/config.php");
	include("../includes/validate_data.php");
	session_start();
		if(isset($_SESSION['manufacturer_login'])) {
			$error = "";
			$querySelectRetailer = "SELECT *,area.area_id AS area_id FROM retailer,area WHERE retailer.area_id = area.area_id";
			$resultSelectRetailer = mysqli_query($con,$querySelectRetailer);
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				if(isset($_POST['cmbFilter'])) {
					if(!empty($_POST['txtInvoiceId'])) {
						$result = validate_number($_POST['txtInvoiceId']);
						if($result == 1) {
							$invoice_id = $_POST['txtInvoiceId'];
							$query_selectInvoice = "SELECT * FROM invoice,retailer,area WHERE invoice.retailer_id=retailer.retailer_id AND retailer.area_id=area.area_id AND invoice_id='$invoice_id'";
							$result_selectInvoice = mysqli_query($con,$query_selectInvoice);
							$row_selectInvoice = mysqli_fetch_array($result_selectInvoice);
							if(empty($row_selectInvoice)){
							   $error = "* ID pada invoice tidak ditemukan";
							}
							else {
								mysqli_data_seek($result_selectInvoice,0);
							}
						}
						else {
							$error = "* ID Invalid ";
						}
					}
					else if(!empty($_POST['txtOrderId'])) {
						$result = validate_number($_POST['txtOrderId']);
						if($result == 1) {
							$order_id = $_POST['txtOrderId'];
							$query_selectInvoice = "SELECT * FROM invoice,retailer,area WHERE invoice.retailer_id=retailer.retailer_id AND retailer.area_id=area.area_id AND order_id='$order_id'";
							$result_selectInvoice = mysqli_query($con,$query_selectInvoice);
							$row_selectInvoice = mysqli_fetch_array($result_selectInvoice);
							if(empty($row_selectInvoice)){
							   $error = "* ID pada invoice tidak ditemukan";
							}
							else {
								mysqli_data_seek($result_selectInvoice,0);
							}
						}
						else {
							$error = "*  ID Invalid";
						}
					}
					else if(!empty($_POST['cmbRetailer'])) {
						$retailer_id = $_POST['cmbRetailer'];
						$query_selectInvoice = "SELECT * FROM invoice,retailer,area WHERE invoice.retailer_id=retailer.retailer_id AND retailer.area_id=area.area_id AND invoice.retailer_id='$retailer_id' ORDER BY invoice_id DESC";
						$result_selectInvoice = mysqli_query($con,$query_selectInvoice);
						$row_selectInvoice = mysqli_fetch_array($result_selectInvoice);
						if(empty($row_selectInvoice)){
						   $error = "* Pelanggan pada invoice tidak ditemukan";
						}
						else {
							mysqli_data_seek($result_selectInvoice,0);
						}
					}
					else if(!empty($_POST['txtDate'])) {
						$date = $_POST['txtDate'];
						$query_selectInvoice = "SELECT * FROM invoice,retailer,area WHERE invoice.retailer_id=retailer.retailer_id AND retailer.area_id=area.area_id AND invoice.date='$date'";
						$result_selectInvoice = mysqli_query($con,$query_selectInvoice);
						$row_selectInvoice = mysqli_fetch_array($result_selectInvoice);
						if(empty($row_selectInvoice)){
						   $error = "* Tanggal pada invoice tidak ditemukan";
						}
						else {
							mysqli_data_seek($result_selectInvoice,0);
						}
						
					}
					else {
						$error = "* Pilih data yang akan dicari";
					}
				}
				else {
					$error = "Pilih opsi yang akan dicari";
				}
			}
			else {
				$query_selectInvoice = "SELECT * FROM invoice,retailer,area WHERE invoice.retailer_id=retailer.retailer_id AND retailer.area_id=area.area_id";
				$result_selectInvoice = mysqli_query($con,$query_selectInvoice);
			}
		}
		else {
			header('Location:../index.php');
		}
?>

<!DOCTYPE html>
<html>
<head>
	<title> Lihat Invoice </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
	<link rel="stylesheet" href="css/smoothness/jquery-ui.css">
	<script type="text/javascript" src="../includes/jquery.js"> </script>
	<script src="js/jquery-ui.js"></script>
	<script>
  $(function() {
    $( "#datepicker" ).datepicker({
     changeMonth:true,
     changeYear:true,
     yearRange:"-100:+0",
     dateFormat:"yy-mm-dd"
  });
  });
  </script>
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_manufacturer.inc.php");
		include("../includes/aside_manufacturer.inc.php");
	?>
	<section>
		<h1>Invoice</h1>
		<form action="" method="POST" class="form">
		Cari: 
		<div class="input-box">
		<select name="cmbFilter" id="cmbFilter">
		<option value="" disabled selected>-- Cari --</option>
		<option value="invoiceId">  ID Invoice </option>
		<option value="orderId"> ID Pesanan </option>
		<option value="retailer"> Pelanggan </option>
		<option value="date"> Tanggal </option>
		</select>
		</div>
		
		<div class="input-box"> <input type="text" name="txtInvoiceId" id="txtInvoiceId" style="display:none;" /> </div>
		<div class="input-box"> <input type="text" name="txtOrderId" id="txtOrderId" style="display:none;" /> </div>
		<div class="input-box">
		<select name="cmbRetailer" id="cmbRetailer" style="display:none;">
			<option value="" disabled selected>-- Pilih Pelanggan --</option>
			<?php while($rowSelectRetailer = mysqli_fetch_array($resultSelectRetailer)) { ?>
			<option value="<?php echo $rowSelectRetailer['retailer_id']; ?>"><?php echo $rowSelectRetailer['area_code']." (".$rowSelectRetailer['area_name'].")"; ?></option>
			<?php } ?>
		</select>
		</div>
		<div class="input-box"> <input type="text" id="datepicker" name="txtDate" style="display:none;"/> </div>
		<input type="submit" class="submit_button" value="Cari" /> <span class="error_message"> <?php echo $error; ?> </span>
		</form>
	
		<form action="" method="POST" class="form">
		<table class="table_displayData" style="margin-top:20px;">
			<tr>
				<th> ID Invoice </th>
				<th> Pelanggan </th>
				<th> Tanggal </th>
				<th> ID Order</th>
				<th> Total Jumlah </th>
				<th> Detail </th>
			</tr>
			<?php while($row_selectInvoice = mysqli_fetch_array($result_selectInvoice)) { ?>
			<tr>
			
				<td> <?php echo $row_selectInvoice['invoice_id']; ?> </td>
				<td> <?php echo $row_selectInvoice['area_code']; ?> </td>
				
				<td> <?php echo date("d-m-Y",strtotime($row_selectInvoice['date'])); ?> </td>
				<td> <?php echo $row_selectInvoice['order_id']; ?> </td>
				<td> <?php echo $row_selectInvoice['total_amount']; ?> </td>
				<td> <a href="view_invoice_items.php?id=<?php echo $row_selectInvoice['invoice_id']; ?>">Detail</a> </td>
			</tr>
			<?php } ?>
		</table>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
	<script type="text/javascript">
		$('#cmbFilter').change(function() {
			var selected = $(this).val();
			if(selected == "invoiceId"){
				$('#txtInvoiceId').show();
				$('#txtOrderId').hide();
				$('#datepicker').hide();
				$('#cmbRetailer').hide();
			}
			else if (selected == "orderId"){
				$('#txtInvoiceId').hide();
				$('#txtOrderId').show();
				$('#datepicker').hide();
				$('#cmbRetailer').hide();
			}
			else if (selected == "retailer"){
				$('#txtInvoiceId').hide();
				$('#txtOrderId').hide();
				$('#datepicker').hide();
				$('#cmbRetailer').show();
			}
			else if (selected == "date"){
				$('#txtInvoiceId').hide();
				$('#txtOrderId').hide();
				$('#datepicker').show();
				$('#cmbRetailer').hide();
			}
		});
	</script>
</body>
</html>