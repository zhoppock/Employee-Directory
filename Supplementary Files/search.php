<form method="post">
    <div class="search_box">
    <input type="text" name="search" placeholder="Search employee by first name, last name, extension, or phone number (or search nothing to return to main list)">
    <input type="submit" name="submit" value="SEARCH">
    </div>
    <?php
    $pdo = new PDO('sqlite:../Supplementary Files/Pechanga_Employee_Directory.db');
    if (isset($_POST["submit"])){
        $str = $_POST["search"];
        $sth = $pdo->prepare("SELECT
        first_name, last_name, division_department, title, email, phone1_office_or_main_line, phone2_mobile, extension, notes_comments
        FROM EMPLOYEES WHERE (division_department = ('$division')) AND
        (first_name LIKE '$str' or last_name LIKE '$str' or extension = '$str' or phone1_office_or_main_line = '$str' or phone2_mobile = '$str')");
        $sth->setFetchMode(PDO:: FETCH_OBJ);
        $sth->execute();
        if($str != NULL){ ?>
            <div class="table_search">
                <table border=5>
                    <tr class="headings">
                        <th><b>FIRST NAME</b></td>
                        <th><b>LAST NAME</b></td>
                        <th><b>DIVISION/DEPARTMENT</b></td>
                        <th><b>TITLE</b></td>
                        <th><b>EMAIL</b></td>
                        <th><b>PHONE1 (OFFICE OR MAIN LINE)</b></td>
                        <th><b>PHONE2 (MOBILE)</b></td>
                        <th><b>EXTENSION</b></td>
                        <th><b>NOTES/COMMENTS</b></td>
                    </tr> <?php
                while($row = $sth->fetch()):
                ?>                                                                
                    <tr>
                        <td><?php echo $row->first_name; ?></td>
                        <td><?php echo $row->last_name; ?></td>
                        <td><?php echo $row->division_department; ?></td>
                        <td><?php echo $row->title; ?></td>
                        <td><?php echo $row->email; ?></td>
                        <td><?php echo $row->phone1_office_or_main_line; ?></td>
                        <td><?php echo $row->phone2_mobile; ?></td>
                        <td><?php echo $row->extension; ?></td>
                        <td><?php echo $row->notes_comments; ?></td>
                    </tr>
                <?php endwhile ?>
                </table>
            </div>
        <?php
            } }
    ?>
</form>
<div class="table_whole">
<table border=5>
<?php

$statement = $pdo->query("SELECT
    first_name, last_name, division_department, title, email, phone1_office_or_main_line, phone2_mobile, extension, notes_comments
FROM
    EMPLOYEES
WHERE
    division_department = ('$division')
ORDER BY
CASE title
    WHEN 'Vice President' THEN 0
    WHEN 'Director' THEN 1
    WHEN 'Assistant Director' THEN 2
    WHEN 'Manager' THEN 3
    WHEN 'Assistant Manager' THEN 4
    WHEN 'Supervisor' THEN 5
    WHEN 'Employee' THEN 6
END, last_name ASC");
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<tr class="headings">
    <th><b>FIRST NAME</b></td>
    <th><b>LAST NAME</b></td>
    <th><b>DIVISION/DEPARTMENT</b></td>
    <th><b>TITLE</b></td>
    <th><b>EMAIL</b></td>
    <th><b>PHONE1 (OFFICE OR MAIN LINE)</b></td>
    <th><b>PHONE2 (MOBILE)</b></td>
    <th><b>EXTENSION</b></td>
    <th><b>NOTES/COMMENTS</b></td>
</tr>

<?php
foreach($rows as $employee => $detail){
    echo "<tr>";
        echo "<td>" . $detail['first_name'] . "</td>";
        echo "<td>" . $detail['last_name'] . "</td>";
        echo "<td>" . $detail['division_department'] . "</td>";
        echo "<td>" . $detail['title'] . "</td>";
        echo "<td>" . $detail['email'] . "</td>";
        echo "<td>" . $detail['phone1_office_or_main_line'] . "</td>";
        echo "<td>" . $detail['phone2_mobile'] . "</td>";
        echo "<td>" . $detail['extension'] . "</td>";
        echo "<td>" . $detail['notes_comments'] . "</td>";
    echo "</tr>";
}
?>
</table>
</div>