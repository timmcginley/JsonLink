<html>

<head>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<link rel="stylesheet" href="css/main.css">
</head>

<body>
	<center>
	<code>
	<?php 
	// get the file id for the json from the url
	$file_id = htmlspecialchars($_GET["id"]);
	$context = "http://www.bim-tools.org/Duplex_A_20110907_optimized/";
	$ifcProject = "7b7032cc-b822-417b-9aea-642906a29bd5.json";
	$_external_source = $context.$file_id;
	$content = file_get_contents($_external_source);
	$data = json_decode($content);
	echo "<div class='main'><br>";
	foreach ($data->decomposes as $decomposes)
	{
		echo "<div class='decomposes'>";
		$url = $decomposes->ref;
		$id = preg_split("#/#", $url); 
		echo '- ';
		// onclick send the fileid to the url...
		echo "<a href='?id=".$id[4]."'>".$decomposes->type.'</a><br>';
		echo '</div>';
	}
	echo "<br><div style ='font-size:30px'>".$data->type.': '.$data->name.'</div>';
	echo '<br>'.$data->globalId.'<br><br>';
	
	foreach ($data->isDecomposedBy[0] as $decomp)
	{
		echo "<div class='decombox'>";
		$url = $decomp->ref;
		$id = preg_split("#/#", $url); 
		echo '- ';
		// onclick send the fileid to the url...
		echo "<a href='?id=".$id[4]."'>".$decomp->type.'</a><br>';
		echo '</div>';
	}

	echo '<br></div>';
	echo "<br><a href='?id=".$ifcProject."'>IfcProject</a>";
	
	?>
	</code>
	</center>
</body>
</html>