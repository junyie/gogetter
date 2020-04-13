<html>
<body>
 

Welcome <?php echo $_POST["name"]; ?><br>
Your email address is: <?php echo $_POST["subject"]; ?><br>

<form action="test.php" method="post">
Name: <input type="text" name="name"><br>
<!--E-mail: <input type="text" name="email"><br-->

<input list="browsers" name="subject" data-ajax="false">
        <datalist id="browsers">
          <?php 
           require_once("sessionchecker.php");

           $query = "SELECT * FROM `categories`"; 
           $searchcateg=$conn->prepare($query);
           $searchcateg->execute();
           $totalcateg = $searchcateg->rowCount();
            foreach ($searchcateg as $rowcate) {
              echo '<option value="'.$rowcate['category'].'">';
            }
          ?>
        </datalist>
<input type="submit">
</form>

</body>
</html>

