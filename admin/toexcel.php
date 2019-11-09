<?PHP
  // Original PHP code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.
require_once './../sql_login/login.php';
$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die("Fatal Error");

$_SESSION['table'] = $_GET['table'];
$table = $_SESSION['table'];
// echo $table."<br>";
  function cleanData(&$str)
  {
   // escape tab characters
    $str = preg_replace("/\t/", "\\t", $str);

    // escape new lines
    $str = preg_replace("/\r?\n/", "\\n", $str);

    // convert 't' and 'f' to boolean values
    if($str == 't') $str = 'TRUE';
    if($str == 'f') $str = 'FALSE';

    // force certain number/date formats to be imported as strings
    if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
      $str = "'$str";
    }

    // escape fields that include double quotes
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // filename for download
  $filename = "data.xls";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

  $flag = false;
  $query= "SELECT * FROM $table";
  $result = $conn->query($query) or die('Query failed!');
  while($row = mysqli_fetch_array($result)) {
    if(!$flag) {
      // display field/column names as first row
      echo implode("\t", array_keys($row))."\r\n";
      $flag = true;
    }
    array_walk($row, __NAMESPACE__ . '\cleanData');
    echo implode("\t", array_values($row)) . "\r\n";
  }
  exit;
?>