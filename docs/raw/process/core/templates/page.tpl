<html>
	<head>
		<title><?=$title?></title>
		<link rel="stylesheet" type="text/css" href="common.css">
	</head>
	
	<body>
		<!-- top nav bar -->
		<div class="navbar">
			<table border="0" cellpadding="0" width="100%">
				<tr>
					<td align="left" width="30%">
						<?=$prev?>
					</td>
					<td align="center" width="30%">
						<?=$parent?"$parent | ":"";?>
						<a href="index.html">Home</a>
					</td>
					<td align="right" width="30%">
						<?=$next?>
					</td>
				</tr>
			</table>
		</div>
		<!-- end -->

		<?=$body?>
		
		<!-- bottom nav bar -->
		<div class="navbar">
			<table border="0" cellpadding="0" width="100%">
				<tr>
					<td align="left" width="30%">
						<?=$prev?>
					</td>
					<td align="center" width="30%">
						<?=$parent?"$parent | ":"";?>
						<a href="index.html">Home</a>
					</td>
					<td align="right" width="30%">
						<?=$next?>
					</td>
				</tr>
			</table>
		</div>
		<!-- end -->
	</body>
</html>