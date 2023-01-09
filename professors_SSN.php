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
        $SSN = $_POST['SSN'];
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
        $sql = "SELECT P.PNAME, C.NUMBER, C.TITLE, S.SECTION_NUMBER, S.CLASSROOM, S.BEGINNING_TIME, S.ENDING_TIME, 
                    (
                        SELECT GROUP_CONCAT(D.MEETING_DAY SEPARATOR ' ')
                        FROM SECTION_MEETING_DAYS D
                        WHERE D.SECTION_NUMBER=S.SECTION_NUMBER
                    ) AS MEETING_DAYS
                FROM PROFESSOR P, COURSE C, SECTION S
                WHERE P.SSN={$SSN} AND P.SSN=S.PROFESSOR_SSN AND C.NUMBER=S.CNUMBER;";

        $result = $con->query($sql);
    ?>

    <div class="container">
        <section class="title" id="title">
            <h1 class="title_header text-xl pl-4">Result Output</h1>
        </section>
        <section class="input" id="input">
        
        <div class="input_data1">
            <div class="table table-zebra w-full">
            <?php
                if ($result->num_rows > 0) {?>
                    <?php 
                         $row = $result->fetch_assoc();
                         echo "<h2 class='text-2xl antialiased py-4'>Hello, Professor ", $row["PNAME"], "<h2>";
                    ?>
            <table class="table w-full"> 
                <thead> 
                <tr> 
                    <th scope="col">Course </th> 
                    <th scope="col">Section </th> 
                    <th scope="col">Course Title </th>
                    <th scope="col">Classroom </th> 
                    <th scope="col">Meeting Days </th> 
                    <th scope="col">Time</th>
                </tr>
                </thead>
                <tbody>
				    <?php foreach($result as $row) { ?>
                        <tr>
                            <td><?php echo $row["NUMBER"]; ?></td>
                            <td><?php echo  $row["SECTION_NUMBER"]; ?></td>
                            <td><?php echo  $row["TITLE"]; ?></td>
                            <td><?php echo  $row["CLASSROOM"];?></td>
                            <td><?php echo  $row["MEETING_DAYS"] ; ?></td>
                            <td><?php echo $row["BEGINNING_TIME"] 
                            . ' - '. $row["ENDING_TIME"] ;?></td>
                        </tr>
                    <?php } ?>
                </tbody>    
            </table>
            </div>
            <?php }
                else {
                    echo "0 results";
                } ?>
            <?php
                $con->close();
            ?>
        </div>  
        </section>
    </div>
</body>
</html>