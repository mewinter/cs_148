<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include "top.php";


//now print out each record
//$columns = 10;
$query = 'SELECT `pmkPlanId`, `fnkStudentNetId`,`fldDateCreated`, `fnkAdvisorNetId`, `pmkYear`, `pmkTerm`, `fldRequirement`,`fldDepartment`, `fldCourseNumber`, `fldCourseName` FROM tblFourYearPlan JOIN tblSemesterPlan on pmkPlanId = tblSemesterPlan.fnkPlanId JOIN tblSemesterPlanCourses ON tblSemesterPlanCourses.fnkPlanId=tblFourYearPlan.pmkPlanId AND tblSemesterPlanCourses.fnkYear = pmkYear AND tblSemesterPlanCourses.fnkTerm = tblSemesterPlan.pmkTerm JOIN tblCourses on pmkCourseId= fnkCourseId WHERE pmkPlanId=1 ORDER BY tblSemesterPlan.fldDisplayOrder, tblSemesterPlanCourses.fldDisplayOrder';
$info2 = $thisDatabaseReader->select($query, "", 1, 3, 0, 0, false, false);
$highlight = 0; // used to highlight alternate rows
//print '<article><p><b>Total Records: ' . count($info2) . '</b></p>';
//print '<p><b>SQL: ' . $query . '</b></p></article>';

$TotalCreditsSem = 0;
$TotalCredits = 0;
$Semester = 0;

print '<ol><div>';

foreach ($info2 as $row) {
    //print "<li>" . $row["pmkTerm"]. ' '. $row["pmkYear"] . "</li>";  
    //check for new term
    print '</ol></div>';
    print"<div><h3>";
    if ($Semester == 0) {
        print $row["pmkTerm"] . ' ' . $row["pmkYear"];
        print"</h3>";
        $Semester = 1;
    }
    $TotalCredits = $TotalCredits + $row["fldCredits"];
    $TotalCreditsSem = $TotalCreditsSem + $row["fldCredits"];
    print 'total credits: '. $TotalCredits . ' total semester credits: '. $TotalCreditsSem;
    print '<ol><li>' . $row['fldDepartment'] . ' ' . $row ['fldCourseNumber'] . ' '. $row['fldCredits'] . '</li>';
    $Semester = 0;
}

//print '<p><table><th>Courses</th>';

print '<article><p><b>Total Records: ' . count($info2) . '</b></p>';
print '<p><b>SQL: ' . $query . '</b></p>';

// the array $records is both associative and indexed, column zero is associative
// which you see in teh above print_r statement
$fields = array_keys($info2[0]);
$labels = array_filter($fields, "is_string");


$columns = count($labels);
print '<table><article>';
print '<tr><th colspan="' . $columns . '">' .'</th></tr>';
// print out the column headings, note i always use a 3 letter prefix
// and camel case like pmkCustomerId and fldFirstName
print '<tr>';
foreach ($labels as $label) {
    print '<th>';
    $camelCase = preg_split('/(?=[A-Z])/', substr($label, 3));
    foreach ($camelCase as $one) {
        print $one . " ";
    }
    print '</th>';
}
print '</tr>';
//now print out each record
foreach ($info2 as $record) {
    print '<tr>';
    for ($i = 0; $i < $columns; $i++) {
        print '<td>'. $record[$i] . '</td>';
    }
    print '</tr>';
}
// all done
print '</table></article>';

include "footer.php";
?>
