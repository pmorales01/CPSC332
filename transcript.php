<html>
<head>
	<title>CPSC 332 - Project 1</title>
</head>
<body>
    <header>
        <div class="navbar">
            <a href="http://ecs.fullerton.edu/~cs332f26" class="btn btn-ghost normal-case text-xl bg-cyan-400">HOME</a>
        </div>
    </header>

    <?php   
      $CWID = $_POST['CWID'];
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
        $sql = "SELECT S.FNAME, S.LNAME, C.NUMBER, C.TITLE, E.GRADE
                FROM ENROLLMENT E, STUDENT S, COURSE C
                WHERE E.CAMPUS_WIDE_ID={$CWID} AND E.CAMPUS_WIDE_ID=S.CAMPUS_WIDE_ID AND C.NUMBER=E.CNUMBER;";

        $result = $con->query($sql);
    ?>

<fieldset>
<legend>Student</legend>

        <?php
            echo "Campus Wide ID: ", $CWID, "<BR>";
            if ($result->num_rows > 0) {?>
                <?php 
                        $row = $result->fetch_assoc();
                        echo "<br>Name: ", $row["FNAME"], " ", $row["LNAME"], "<br>";
                ?>
                 <?php foreach($result as $row) { 
                    echo "Course Number: ", $row["NUMBER"], "<br>";
                    echo "Course Title: ", $row["TITLE"], "<br>";
                    echo "Grade: ", $row["GRADE"], "<BR>", "<br>";
                } ?>
     <?php }
            else {
                echo "0 results", "<br>";
                echo "STUDENT NOT FOUND", "<br>";
            } ?>
    <?php
        $con->close();
    ?>
</fieldset>
</div>
<button onclick="goBack()">Go Back</button>

<script>
function goBack() {
    window.history.back();
}
</script>
</body>
</html>