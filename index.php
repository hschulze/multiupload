

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Cp1252">
<title>Products</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
    <div id="galerie_div">
		Vorhandene Produkte (Zum Bearbeiten anklicken):
		<ul id="galerie">
			<?php 
				$db = @new mysqli('localhost', 'galerieuser', 'galerieuser', 'galerie');
				if(mysqli_connect_errno() == 0) {
					$stmt = $db->stmt_init();
					if(!$stmt->prepare("SELECT id, name FROM products")) {
						die($db->error);
					}
					$stmt->execute();
					$result = $stmt->get_result();
					
					while ($row = $result->fetch_assoc()) {
						$stmt = $db->stmt_init();
						if(!$stmt->prepare("SELECT thumbname FROM bilder WHERE productid = ? ORDER BY ismainthumb DESC")) {
							die($db->error);
						}
						$id = $row['id'];
						$name = $row['name'];
						$stmt->bind_param('i', $id);
						$stmt->execute();
						$result_product = $stmt->get_result();
						
 						?>
						<li>
							<a href="product.php?id=<?php echo "$id"?>">
								<?php
									if($result_product->num_rows > 0) {
											$row_product = $result_product->fetch_assoc();
								?>
										<img src="uploads/<?php echo $row_product['thumbname'] . ".jpg";?>" width="140" height="140" alt="Vorschau" />
								<?php 
									} else {
								?>
										<img src="pics/no_pic.jpg" width="140" height="140" alt="Keine Vorschau" />
								<?php 
									}
									echo "$name";
								?>
							</a>
						</li>
						<?php 
						$result_product->close();
						$stmt->close();
					}
					$result->close();
					$db->close();
				} else {
					echo "Es konnte keine Verbindung zur Datenbank hergestellt werden";
				}
			?>
		</ul>
	</div>
</body>
</html>