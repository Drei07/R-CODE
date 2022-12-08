<table class="table table-bordered ">
<?php

include_once 'database/dbconfig2.php';

function get_total_row($pdoConnect)
{
  $query = "
  SELECT * FROM user
  ";
  $statement = $pdoConnect->prepare($query);
  $statement->execute();
  return $statement->rowCount();
}

$total_record = get_total_row($pdoConnect);
$limit = '20';
$page = 1;
if(isset($_POST['page']))
{
  $start = (($_POST['page'] - 1) * $limit);
  $page = $_POST['page'];
}
else
{
  $start = 0;
}

$query = "
SELECT * FROM admin WHERE account_status = :account_status
";
$output = '';
if($_POST['query'] != '')
{
  $query .= '
  AND business_name LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"
  ';
}

$query .= 'ORDER BY userId DESC ';

$filter_query = $query . 'LIMIT '.$start.', '.$limit.'';

$statement = $pdoConnect->prepare($query);
$statement->execute(array(":account_status" => "active"));
$total_data = $statement->rowCount();

$statement = $pdoConnect->prepare($filter_query);
$statement->execute(array(":account_status" => "active"));
$total_filter_data = $statement->rowCount();

if($total_data > 0)
{
  while($row=$statement->fetch(PDO::FETCH_ASSOC))
  {
    $output .= '
    <div class="seller-data">
        <div class="seller-head">
            <img src="src/img/'.$row["adminProfile"].'" alt="logo">
            <h1 class="title">'.$row["business_name"].'</h1>
        </div>

        <div class="seller-button">
            <button><a href="seller-info?Id='.$row["userId"].'">View</a></button>
        </div>

    </div>
    ';
  }
}
else
{
  echo '<h1 class="no-data">No Data Found</h1>';
}

$output .= '
</table>
';

$previous_link = '';
$next_link = '';
$page_link = '';

//echo $total_links;

$output .= $previous_link . $page_link . $next_link;
$output .= '
  </ul>

</div>
';

echo $output;

?>

<script src="../../src/node_modules/sweetalert/dist/sweetalert.min.js"></script>
<script>


</script>
</table>