<?php  
include ("include.php");
session_start();
if(!isset($_SESSION['username']))
{
    $loged = false;
    header("Location: index.php");
    echo "Invalid Location";
    return;
}
else $loged= true;
?>


<html>
    <head>
        <title>Your userpage... <?php echo $_SESSION['username']?></title>
        <?php include("head.php");?>
    </head>
    <body>
        <?php include("topbar.php") ?>
         <div id="main">
             
             <h1>User Page</h1>
            <p>Welcome <span id="username"><?php echo $_SESSION['username'];?></span></p><br><br>
             
             <div>
                 <form id="addlink" method="post" action="addlink.php">
                     <label for="link">Insert Link</label>
                     <input type="text" name="link" maxlength="200" required>
                     <input type="submit" name="submit" value="Insert">
                     <input type="reset">
                 </form>
             </div>
             <br><br>
            <p>Your links are:</p>
            
            
        <?php
            $conn = new mysqli($host, $username, $password,$dbname);
            if (mysqli_connect_error()) {
                die("Database connection failed: " . mysqli_connect_error());
            }
            $conn = new mysqli($host, $username, $password,$dbname);
            if (mysqli_connect_error()) {
                die("Database connection failed: " . mysqli_connect_error());
            }
$sqli = "SELECT userid FROM users WHERE username = '{$_SESSION['username']}'";
$result= $conn->query($sqli);
$row = $result->fetch_assoc();
$uid = $row['userid'];

            $sql = "SELECT linkid, link, userid, datetime FROM links where userid='{$uid}' order by datetime desc";
            $result = $conn->query($sql);
            if($result->num_rows > 0)
            {
                echo "<table id=\"links\">\n";
                echo "<tr id=\"tdes\"> <th>Link</th>\n<th>Entry date</th>\n<th>Delete</th>\n</tr>\n";
                
                while($row = $result->fetch_assoc()) {
                    
                    ?>
                    <tr class="linktr">
                   <td class="link"><a href="<?php echo $row['link'] ?>"><?php echo $row['link']?></a></td>
                    <td class = "time"><?php echo $row['datetime']?></td>
                    <td> <form method="post" action="deletelink.php"><input type="hidden" name="linkid" value="<?php echo $row['linkid']?>">
                        <input type="submit" value="Delete" name="submit"></form></td>
                    </tr>
             <?php
                }
                echo "</table>";
            }
            else
                echo "<p class=\"error\">No links</p>";
            
        ?>
             
        </div>
    </body>
</html>