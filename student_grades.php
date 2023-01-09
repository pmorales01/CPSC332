<html>
<head>
	<title>CPSC 332 - Project 1</title>
	<link href="./dist/output.css" rel="stylesheet">
</head>
<body>
	<header>
		<div class="navbar">
			<a href="http://ecs.fullerton.edu/~cs332f26" class="btn btn-ghost normal-case text-xl bg-cyan-400">HOME</a>
		</div>
	</header>
    <?php   
        $CNO = $_POST['CNO'];
				
		$CNO = strtoupper(json_encode($CNO)); // encode to JSON

		$SNO = $_POST['SNO'];

        $dbServername = "mariadb";
        $dbUsername = "cs332f26";
        $dbPassword = "6Kqjr0YR";
        $dbName = "cs332f26";

        // set connection
        $con= mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

        //check connection
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        }
    ?>
 	<?php
		$sql = "SELECT L.GRADE, COUNT(R.CAMPUS_WIDE_ID) AS NUMBER_OF_STUDENTS
				FROM ENROLLMENT L
				LEFT JOIN (
		  			SELECT *
		  			FROM ENROLLMENT
		  			WHERE CNUMBER={$CNO} AND SECTION_NUMBER={$SNO}) R
				ON L.CAMPUS_WIDE_ID=R.CAMPUS_WIDE_ID AND L.CNUMBER=R.CNUMBER AND L.SECTION_NUMBER=R.SECTION_NUMBER
		GROUP BY L.GRADE;";

        $result = $con->query($sql);
		$CNO = json_decode($CNO); // decode CNO
    ?>
	
	
<div class="container">
	<section class="title" id="title">
		<h2 class="text-2xl antialiased py-2 pl-4"> <?php echo "COURSE: ", $CNO ;?></h2>
		<h2 class="text-2xl antialiased py-2 pl-4"> <?php echo "SECTION: ", $SNO ;?></h2>
	</section>	

	<section class="input" id="input">  
		<div class="input_data1">
			<div class="container2">
			<?php 	
			$nor =$result->num_rows;
			if ($result->num_rows > 0) { 
			?>
				<table class="table w-full"> 
				<thead>	
				<tr> 
					<th scope="col">Grade </th> 
					<th scope="col"># of Students </th> 
				</tr>
				</thead>
				<tbody>
		
				<?php while($row = $result->fetch_assoc()) { ?>
						<tr>
							<td> <?php echo  $row["GRADE"] ;?></td>
							<td><?php echo  $row["NUMBER_OF_STUDENTS"] ; ?></td>
							</tr>	
					<?php } ?>
						</tbody>
					</table>
				
		<?php 
			} else {
				echo "0 results";
			} 
		?>

		<?php 
		$con->close();
		?>	
			</div>
		</div>
  	</section>
</div>
</body>
</html>
