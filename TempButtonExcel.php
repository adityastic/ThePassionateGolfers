<html>
<body>
	<table>
		<tr>
			<th>
				Tournament Name
			</th>
			<th>
				Excel Button
			</th>
		</tr>
<?php

include 'connect.php';

$sqlJSON = mysqli_query($conn, "SELECT * FROM tbgolftournament");
while($sqlAns = mysqli_fetch_array($sqlJSON))
{
	echo '<tr>';
	echo '<td>';
	echo $sqlAns['gtname'];
	echo '</td>';
	echo '<td>';
	echo '<form method="POST" action="ExcelGeneration/excel.php?id=' . $sqlAns['gtid'] . '"><input type="submit" value="Generate Excel"></form>';
	echo '</td>';
	echo '</tr>';
}

?>
	</table>
</body>
</html>