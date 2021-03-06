<html>

<head>
	<!--- NOT ALLOWED ... ONLY PHP AND VANILLA JS .... ok plus a bit of CSS
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> 
	-->
	<link rel="stylesheet" href="css/main.css">
</head>

<body>

	<code>
	
	<?php 
	// get the file id for the json from the url
	$file_id = htmlspecialchars($_GET["id"]);
	// this could mature into proper linked data context
	$context = "http://www.bim-tools.org/Duplex_A_20110907_optimized/";
	// this is a default / home file to start the navigation and in case the URL param gets us lost
	$ifcProject = "7b7032cc-b822-417b-9aea-642906a29bd5.json";
	// conacatenate the context and file name from the url
	$_external_source = $context.$file_id;
	// get the content of the file
	$content = file_get_contents($_external_source);
	// decode the content
	$data = json_decode($content);
	// build a main div to house the data
	
	?>
	
	<div class='main'><br><?php 
		// get the parent data of the current element
		// not sure if this needs a loop - could we have more than one decompose?
		// if so would that change the structure of the array, so this wouldn't work anyway?
		
		foreach ($data->decomposes as $decomposes)
		{
			echo "<div class='decomposes'>";
			$url = $decomposes->ref;
			$id = preg_split("#/#", $url); 
			echo '<< ';
			// onclick send the fileid to the url...
			echo "<a href='?id=".$id[4]."'>".$decomposes->type.'</a><br>';
			echo '</div>';
		}

		// get the data for the current element
		echo "<h1>".$data->type.': '.$data->name.'</h1>';
		echo "<div class='viewer'></div>";
		echo "<div class='viewbase'>".$data->globalId."</div>";
		
		// get the child data of the current element
		echo '<h2>IsDecomposedBy</h2>';
		foreach ($data->isDecomposedBy[0] as $decomp)
		{
			echo "<div class='decombox'>";
			$url = $decomp->ref;
			// split the ref to get the filename
			$id = preg_split("#/#", $url); 
			echo '>> ';
			// onclick send the filename to the url...
			echo "<a href='?id=".$id[4]."'>".$decomp->type.'</a>';
			echo '<br></div>';
		}
		
		?><h2>Properties</h2><?php
			
			foreach($data as $key => $val) {
				echo "<div class ='keybox'>"; 
				if ($key) { echo $key.':'; };
				if ($val) { echo $val; };
				echo '</div>';
			}					
		?>
	<br>
	
	<?php 
	// add an escape route at the bottom in case it all goes crazy
	echo "<br>Return to <a href='?id=".$ifcProject."'>IfcProject</a>";
	// add credit
	echo "<br><br>Based on a linked ifc JSON experiment by <a href='https://github.com/janbrouwer'>Jan Brouwer.</a>";
	
	?>
	</div>
	</code>
</body>
</html>