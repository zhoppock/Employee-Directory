<?php
	ob_start();
	session_start();
	$conn = new PDO('sqlite:../Supplementary Files/Pechanga_Employee_Directory.db');
	$page_messages = Array();
	
	if( isset($_POST['submit']) ){

		$cleanedUsername = strtolower(strip_tags(trim($_POST['username']))); // Lowercase (strtolower) to make SQL case insensitive.
		$cleanedPassword = strip_tags(trim($_POST['password']));
        $hashed_password = crypt($cleanedPassword, 'rl');
        
        $loginquery = $conn -> prepare("SELECT * FROM ACCOUNTS WHERE lower(user) = '$cleanedUsername'");
        $loginquery->execute();
        while($loginresult = $loginquery->fetchAll()):
            if(isset($loginresult[0]['user']) && !strcmp($hashed_password, $loginresult[0]['pass'])){
                $_SESSION['account-username'] = $loginresult[0]['user'];
                $_SESSION['account-ipaddress'] =  $loginresult[0]['ipaddress'];
                $_SESSION['account-connected'] = true;
                header("Location: http://localhost:1234/webpages/pechanga_directory_administrative_search.php?");
            }
        endwhile;
        if(!isset($loginresult[0]['user']) || strcmp($hashed_password, $loginresult[0]['pass'])){
            array_push($page_messages, "Invalid username or password.");
        }
	}
?>
<html>
    <head>
        <title>Pechanga - Administration Log In</title>
        <link rel="stylesheet" href="../Supplementary Files/theme.css">
        <link rel="icon" type="image/x-icon" href="../Pechanga Assets/P symbol.ico">
    </head>
    <body>
        <div class="fade-in-image">
            <div class="banner">
                <div class="navbar">
                    <a href="https://www.pechanga.com/"><img src="../Pechanga Assets/PCH_Logo.png" class="logo"></a>
                    <ul>
                        <li><a href="../pechanga_directory_main_page.html">Return to Main Page</a></li>
                    </ul>
                </div>

                <div class="content">
                    <?php
                    if($page_messages){
                        foreach($page_messages as $txt){
                            echo "<p>".$txt."</p>";
                        }
                    }
                    ?>
                    <h1>ADMINISTRATION LOG IN</h1>
                    <p>Please log in to access administrative priviledges.</p>
                    <div class="input_box">
                        <form method="post">
                            <p>Username</p>
                            <input type="input" name="username" placeholder="Enter Username">
                            <p>Password</p>
                            <input type="password" name="password" placeholder="Enter Password">
                            <input type="submit" name="submit" value="Login"/>
                        </form>
                    </div>
                </div>
            </div> 
            <div class="footer">
                <h3> Designed by Zachary Hoppock, 2022<br> (C) Pechanga 2002 - 2022</h3>
            </div> 
        </div>
    </body>
</html>