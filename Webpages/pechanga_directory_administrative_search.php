<?php
    ob_start();
    session_start();

	if( !isset($_SESSION['account-connected']) ) {
		header("Location: http://localhost:1234/webpages/pechanga_directory_administrative_login.php");
		exit;
	}
?>

<html>
    <head>
        <title>Pechanga - Administrative Directory</title>
        <link rel="stylesheet" href="../Supplementary Files/theme.css">
        <link rel="icon" type="image/x-icon" href="../Pechanga Assets/P symbol.ico">
    </head>
    <body>
        <div class="fade-in-image">
            <div class="banner">
                <div class="navbar">
                    <a href="https://www.pechanga.com/"><img src="../Pechanga Assets/PCH_Logo.png" class="logo"></a>
                    <ul>
                        <li>
                        <form method="post" action="../Supplementary Files/admin_logout.php?logout">
                            <input type="submit" value="LOG OUT AND RETURN TO MAIN PAGE">
                        </form>
                        </li>
                    </ul>
                </div>

                <div class="content">
                    <h1>ADMINISTRATIVE DIRECTORY</h1>
                    <?php if (!isset($_REQUEST['edit']) || !empty($_REQUEST['submit'])){?>
                    <p>Select an employee to make changes to their information.</p>
                        <form method="post">
                            <div class="search_box">
                            <input type="text" name="search" placeholder="Search employee by first name, last name, extension, or phone number (or search nothing to return to main list)">
                            <input type="submit" name="submit_search" value="SEARCH">
                            </div>
                            <?php   }
                    if (isset($_REQUEST["submit_search"])){
                        $str = $_POST["search"];
                        $dbh = new PDO('sqlite:../Supplementary Files/Pechanga_Employee_Directory.db');
                        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

                        $ListSQL = $dbh->prepare("SELECT * FROM EMPLOYEES WHERE
                        (first_name LIKE '$str' or last_name LIKE '$str' or extension = '$str' or phone1_office_or_main_line = '$str' or phone2_mobile = '$str')
                        ORDER BY division_department");
                        $GetEmployeeSQL = $dbh->prepare("SELECT * FROM EMPLOYEES WHERE id=?");
                        $DeleteSQL = $dbh->prepare("DELETE FROM EMPLOYEES WHERE id=?");
                        $InsertSQL = $dbh->prepare("INSERT INTO EMPLOYEES
                        (first_name, last_name, division_department, title, email, phone1_office_or_main_line, phone2_mobile, extension, notes_comments) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $UpdateSQL = $dbh->prepare("UPDATE EMPLOYEES
                        SET first_name=?, last_name=?, division_department=?, title=?, email=?, phone1_office_or_main_line=?, phone2_mobile=?, extension=?, notes_comments=? WHERE id=?");

                        if($str != NULL){ ?>
                            <div class="table_search_admin">
                                <table border=5>
                                <?php

                                $ListSQL->execute();
                                $Employees = $ListSQL->fetchAll(PDO::FETCH_ASSOC);
                                $ListSQL->closeCursor();
                                ?>
                                <tbody>
                                <tr class="headings"><th>FIRST NAME</th><th>LAST NAME</th><th>DIVISION/DEPARTMENT</th><th>TITLE</th><th>EMAIL</th>
                                <th>PHONE1 (OFFICE OR MAIN LINE)</th><th>PHONE2 (MOBILE)</th><th>EXTENSION</th><th>NOTES/COMMENTS</th><th>&nbsp;</th></tr>
                                <?php
                                foreach( $Employees as $ThisEmployee ) {
                                    echo "<tr>";
                                    echo "<td>".$ThisEmployee['first_name']."</td>";
                                    echo "<td>".$ThisEmployee['last_name']."</td>";
                                    echo "<td>".$ThisEmployee['division_department']."</td>";
                                    echo "<td>".$ThisEmployee['title']."</td>";
                                    echo "<td>".$ThisEmployee['email']."</td>";
                                    echo "<td>".$ThisEmployee['phone1_office_or_main_line']."</td>";
                                    echo "<td>".$ThisEmployee['phone2_mobile']."</td>";
                                    echo "<td>".$ThisEmployee['extension']."</td>";
                                    echo "<td>".$ThisEmployee['notes_comments']."</td>";
                                    echo "<td><a href='?edit=".$ThisEmployee['id']."'>Edit</a>&nbsp;";
                                    echo "<a href='?delete=".$ThisEmployee['id']."'>Delete</a></td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                            </div>
                        <?php
                            } }
                    ?>
                    </form>
                    <?php
                        $dbh = new PDO('sqlite:../Supplementary Files/Pechanga_Employee_Directory.db');
                        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

                        $ListSQL = $dbh->prepare("SELECT * FROM EMPLOYEES ORDER BY division_department");
                        $GetEmployeeSQL = $dbh->prepare("SELECT * FROM EMPLOYEES WHERE id=?");
                        $DeleteSQL = $dbh->prepare("DELETE FROM EMPLOYEES WHERE id=?");
                        $InsertSQL = $dbh->prepare("INSERT INTO EMPLOYEES
                        (first_name, last_name, division_department, title, email, phone1_office_or_main_line, phone2_mobile, extension, notes_comments) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $UpdateSQL = $dbh->prepare("UPDATE EMPLOYEES
                        SET first_name=?, last_name=?, division_department=?, title=?, email=?, phone1_office_or_main_line=?, phone2_mobile=?, extension=?, notes_comments=? WHERE id=?");
                        
                    ?>
                    <div class="table_whole_admin">
                    <table border=5>
                        <?php

                        $ListSQL->execute();
                        $Employees = $ListSQL->fetchAll(PDO::FETCH_ASSOC);
                        $ListSQL->closeCursor();
                        ?>
                        <tbody>
                        <tr class="headings"><th>FIRST NAME</th><th>LAST NAME</th><th>DIVISION/DEPARTMENT</th><th>TITLE</th><th>EMAIL</th>
                        <th>PHONE1 (OFFICE OR MAIN LINE)</th><th>PHONE2 (MOBILE)</th><th>EXTENSION</th><th>NOTES/COMMENTS</th><th>&nbsp;</th></tr>
                        <?php
                        foreach( $Employees as $ThisEmployee ) {
                            echo "<tr>";
                            echo "<td>".$ThisEmployee['first_name']."</td>";
                            echo "<td>".$ThisEmployee['last_name']."</td>";
                            echo "<td>".$ThisEmployee['division_department']."</td>";
                            echo "<td>".$ThisEmployee['title']."</td>";
                            echo "<td>".$ThisEmployee['email']."</td>";
                            echo "<td>".$ThisEmployee['phone1_office_or_main_line']."</td>";
                            echo "<td>".$ThisEmployee['phone2_mobile']."</td>";
                            echo "<td>".$ThisEmployee['extension']."</td>";
                            echo "<td>".$ThisEmployee['notes_comments']."</td>";
                            echo "<td><a href='?edit=".$ThisEmployee['id']."'>Edit</a>&nbsp;";
                            echo "<a href='?delete=".$ThisEmployee['id']."'>Delete</a></td>";
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                    </div>
                    <?php if (!isset($_REQUEST['edit']) || !empty($_REQUEST['submit'])){?>
                    <div class="add_employee">
                    
                    <p />
                    <form method='POST' action='?'><b>Add New Employee Record</b><br />
                    &nbsp;First Name: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp; <input type='text' name='first_name' placeholder='*Required Input' />&nbsp;
                    Last Name: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp; <input type='text' name='last_name' placeholder='*Required Input' />&nbsp;<br />
                    Division/Department: &emsp;&emsp;&emsp; <input type='text' name='division_department' placeholder='*Required Input' />&nbsp;
                    Title: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp; <input type='text' name='title' placeholder='*Required Input' /><br />
                    Email: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp; <input type='text' name='email' placeholder='*Required Input' />&nbsp;
                    Phone1 (Office or Main Line): <input type='text' name='phone1_office_or_main_line' placeholder='*Required Input' /><br />
                    Phone2 (Mobile): &emsp;&emsp;&emsp;&emsp;&ensp;&nbsp; <input type='text' name='phone2_mobile' />&nbsp;
                    Extension: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <input type='text' name='extension' /><br />
                    Notes/Comments: &emsp;&emsp;&emsp;&emsp;&nbsp; <input type='text' name='notes_comments' />&nbsp;
                    &ensp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;<input type='submit' name='add' value='Submit' />&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</form>
                    <br /></div> <?php }
                
                    if( !empty($_REQUEST['delete']) && is_numeric($_REQUEST['delete'])) 
                        {
                            $DeleteSQL->execute(array($_REQUEST['delete']));	
                            $DeleteSQL->closeCursor();
                            ?><p><div class="Update">Employee Deleted (Page will update in 3 seconds)</div></p><?php
                            header( "refresh:3;url=http://localhost:1234/webpages/pechanga_directory_administrative_search.php" );
                        }
                        
                    if( !empty($_REQUEST['add']) && !empty($_REQUEST['first_name']) &&
                            !empty($_REQUEST['last_name']) && !empty($_REQUEST['division_department']) && !empty($_REQUEST['title']) && !empty($_REQUEST['email'])
                            && !empty($_REQUEST['phone1_office_or_main_line']))
                        {
                            $InsertSQL->execute(array($_REQUEST['first_name'], $_REQUEST['last_name'], $_REQUEST['division_department'], $_REQUEST['title'], $_REQUEST['email'],
                                                $_REQUEST['phone1_office_or_main_line'], $_REQUEST['phone2_mobile'], $_REQUEST['extension'], $_REQUEST['notes_comments']));	
                            $InsertSQL->closeCursor();
                            ?><p><div class="Update">Employee Added (Page will update in 3 seconds)</div></p><?php
                            header("refresh: 3");
                        }
                    if( !empty($_REQUEST['edit']) && is_numeric($_REQUEST['edit']) ) {
                            if( !empty($_REQUEST['submit']) ) {
                                $UpdateSQL->execute(array($_REQUEST['first_name'], $_REQUEST['last_name'], $_REQUEST['division_department'],
                                                        $_REQUEST['title'], $_REQUEST['email'], $_REQUEST['phone1_office_or_main_line'],
                                                        $_REQUEST['phone2_mobile'], $_REQUEST['extension'], $_REQUEST['notes_comments'],
                                                        $_REQUEST['id']) );
                                
                                $UpdateSQL->closeCursor();
                                ?><p><div class="Update">Employee Info Updated (Page will update in 3 seconds)</div></p><?php
                                header("refresh: 3");
                            } else {
                                $GetEmployeeSQL->execute(array($_REQUEST['edit']));
                                $Employee = $GetEmployeeSQL->fetch(PDO::FETCH_ASSOC);
                                $GetEmployeeSQL->closeCursor();
                                ?><div class="edit_employee"><?php
                                echo "<form method='POST' action='?'>";
                                echo "<p / >";
                                echo "<b>Edit Employee Record</b><br />";
                                echo "<p / >";
                                echo "&nbsp;First Name: &emsp;&emsp;&emsp;&ensp;&nbsp; <input type='text' name='first_name' value='".
                                    $Employee['first_name']."' />&ensp;";
                                echo "Last Name: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;&nbsp; <input type='text' name='last_name' value='".
                                    $Employee['last_name']."' />&nbsp;<br />";
                                echo "Division/Department: <input type='text' name='division_department' value='".
                                    $Employee['division_department']."' />&ensp;";
                                echo "Title: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;&nbsp; <input type='text' name='title' value='".
                                    $Employee['title']."' /><br />";
                                echo "Email: &emsp;&emsp;&emsp;&ensp;&emsp;&emsp;&ensp;&nbsp; <input type='text' name='email' value='".
                                    $Employee['email']."' />&ensp;";
                                echo "Phone1 (Office or Main Line): <input type='text' name='phone1_office_or_main_line' value='".
                                    $Employee['phone1_office_or_main_line']."' /><br />";
                                echo "Phone2 (Mobile): &emsp;&nbsp; <input type='text' name='phone2_mobile' value='".
                                    $Employee['phone2_mobile']."' />&ensp;";
                                echo "Extension: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp; <input type='text' name='extension' value='".
                                    $Employee['extension']."' /><br />";
                                echo "Notes/Comments: &emsp; <input type='text' name='notes_comments' value='".
                                    $Employee['notes_comments']."' />&nbsp;&emsp;";
                                echo "<input type='hidden' name='id' value='".
                                    $Employee['id']."' />";
                                echo "&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;<input type='hidden' name='edit' value='1' />";
                                echo "<input type='submit' name='submit' value='Submit' />&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;</form>";
                            }
                        }   ?>
                    </div>
                </div>
            <div class="footer">
                <h3> Designed by Zachary Hoppock, 2022<br> (C) Pechanga 2002 - 2022</h3>
            </div> 
        </div>
    </body>
</html>