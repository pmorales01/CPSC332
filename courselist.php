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
        $sql = "SELECT C.NUMBER, S.SECTION_NUMBER, S.CLASSROOM, S.NUMBER_OF_SEATS,
					(
						SELECT GROUP_CONCAT(D.MEETING_DAY SEPARATOR ' ')
						FROM SECTION_MEETING_DAYS D
						WHERE D.SECTION_NUMBER=S.SECTION_NUMBER
					) AS MEETING_DAYS,
					S.BEGINNING_TIME, S.ENDING_TIME,
					(
					SELECT COUNT(*)
					FROM ENROLLMENT E
					WHERE E.SECTION_NUMBER=S.SECTION_NUMBER
					) AS TOTAL_ENROLLED
	  			FROM COURSE C, SECTION S
	 			WHERE C.NUMBER={$CNO} AND C.NUMBER=S.CNUMBER;";

        $result = $con->query($sql);
    ?>

<div class="container">
<section class="title" id="title">
	<h2 class="title_header text-2xl antialiased py-2 pl-4">Result Output</h2>
</section>

<section class="input" id="input">  
	<div class="input_data1">
		<div class="container2">

		<?php
		if ($result->num_rows > 0) {?>
			<table class="table">
				<thead>
				<tr> 
					<th scope="col">Course Number </th> 
					<th scope="col">Section Number </th> 
					<th scope="col">Classroom </th> 
					<th scope="col">Meeting Days </th> 
					<th scope="col">Time</th>
					<th scope="col">Total Enrolled / Seats Available</th>
				</tr>
				</thead>
				<tbody>
				<?php while($row = $result->fetch_assoc()) { ?>
					<tr>
					<td><?php echo  $row["NUMBER"] ; ?></td>
					<td><?php echo  $row["SECTION_NUMBER"] ; ?></td>
					<td><?php echo  $row["CLASSROOM"] ; ?></td>
					<td><?php echo  $row["MEETING_DAYS"] ; ?></td>
					<td><?php echo $row["BEGINNING_TIME"] 
			 				. ' - '. $row["ENDING_TIME"] ;?></td>
					<td><?php echo $row["TOTAL_ENROLLED"] 
			 				. ' / '. $row["NUMBER_OF_SEATS"] ;?></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		
		<?php } 
		else {
			echo "0 results";
		}?>

		<?php
		$con->close();
		?>
		</div>
	</div>
</section>
</div>
</body>

</html>