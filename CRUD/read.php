<?php     // read record  (Show Data)

// Check existence of id parameter before processing further
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
  // Include config file
  require_once "config.php";

  // Prepare a select statement
  $sql = "SELECT * FROM employees WHERE id = ?";

  if ($stmt = mysqli_prepare($link, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $param_id);

    // Set parameters
    $param_id = trim($_GET["id"]);

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
      $result = mysqli_stmt_get_result($stmt);

      if (mysqli_num_rows($result) == 1) {
        /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        // Retrieve individual field value
        $name = $row["name"];
        $address = $row["address"];
        $salary = $row["salary"];
      } else {
        // URL doesn't contain valid id parameter. Redirect to error page
        header("location: error.php");
        exit();
      }
    } // if of execute()
    else {
      echo "Oops! Something went wrong. Please try again later.";
    }
  } // if of mysqli_prepare()

  // Close statement
  mysqli_stmt_close($stmt);

  // Close connection
  mysqli_close($link);
} else {
  // URL doesn't contain id parameter. Redirect to error page
  header("location: error.php");
  exit();
}
?>

<html>

<head>
  <meta charset="UTF-8">
  <title>View Record</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <style>
    .wrapper {
      width: 600px;
      margin: 0 auto;
    }

    #customers {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    #customers td,
    #customers th {
      border: 1px solid #ddd;
      padding: 8px;
    }

    #customers tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    #customers tr:hover {
      background-color: #ddd;
    }

    #customers th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #04AA6D;
      color: white;
    }
  </style>
</head>

<body>
  <br>
  <br>

  <div class="wrapper">
    <table id="customers">
      <h2> View of Employee Details </h2>
      <tr>
        <th>Name</th>
        <th>Address</th>
        <th>Salary</th>
      </tr>
      <tr>
        <td><?php echo $row["name"]; ?></td>
        <td><?php echo $row["address"]; ?></td>
        <td><?php echo $row["salary"]; ?></td>
      </tr>
    </table>
    <p><a href="index.php" class="btn btn-primary">Back</a></p>
  </div>
</body>

</html>