

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
					if(!$stmt->prepare("SELECT id, name, beschreibung FROM products")) {
						die($db->error);
					}
					$stmt->execute();
					$stmt->store_result();	// ermöglicht es, dass ein zweites Query aufgerufen werden kann
					$stmt->bind_result($id, $name, $beschreibung);
					
					while ($stmt->fetch()) {
						$stmt_product = $db->stmt_init();
						if(!$stmt_product->prepare("SELECT thumbname FROM bilder WHERE productid = ? AND ismainthumb = '1'")) {
							die($db->error);
						}
						$stmt_product->bind_param('s', $id);
						$stmt_product->execute();
						
 						?>
						<li>
							<a href="product.php?id=<?php echo "$id"?>">
								<?php
									if($stmt_product->num_rows == 1) {
											$stmt_product->bind_result($thumbname);
											$stmt_product->fetch();
								?>
										<img src="uploads/<?php echo "$thumbname.jpg";?>" width="140" height="140" alt="Vorschau" />
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
						$stmt_product->close();
					}
					$stmt->close();
					$db->close();
				} else {
					echo "Es konnte keine Verbindung zur Datenbank hergestellt werden";
				}
			?>
		</ul>
	</div>
</body>
</html>