<?php
@include 'inc/connection.php';
session_start();

function getElectionStatus($starting_date, $ending_date)
{
    $current_date = new DateTime();
    $start_date = new DateTime($starting_date);
    $end_date = new DateTime($ending_date);

    // We need to add 1 day to the end date to include the entire ending date in the comparison
    $end_date->add(new DateInterval('P1D'));

    if ($start_date <= $current_date && $end_date > $current_date) {
        return "Active";
    } elseif ($end_date < $current_date) {
        return "Expired";
    } else {
        return "Inactive";
    }
}

if (isset($_POST['add_election'])) {
    $election_topic = mysqli_real_escape_string($conn, $_POST['election_topic']);
    $number_of_candidates = mysqli_real_escape_string($conn, $_POST['number_of_candidates']);
    $starting_date = mysqli_real_escape_string($conn, $_POST['starting_date']);
    $ending_date = mysqli_real_escape_string($conn, $_POST['ending_date']);
    $inserted_by = $_SESSION['admin'];
    $inserted_on = date("Y-m-d");
 

    $status = getElectionStatus($starting_date, $ending_date);

    if (empty($election_topic) || empty($number_of_candidates) || empty($starting_date) || empty($ending_date)) {
        echo '<script>
            alert("Please fill out all fields.");
            window.location = "addelection.php";
        </script>';
    } else {
        $insert = "INSERT INTO elections (election_topic, no_of_candidates, starting_date, ending_date, status, inserted_by, inserted_on) 
        VALUES ('$election_topic', '$number_of_candidates', '$starting_date', '$ending_date', '$status', '$inserted_by', '$inserted_on')";
        $upload = mysqli_query($conn, $insert);
        if ($upload) {
            echo '<script>
                alert("New Election added successfully.");
                window.location = "addelection.php";
            </script>';
        } else {
            $message[] = 'Could not add the election.';
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM elections WHERE election_id = $id");
    header('location:addelection.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>dashboard</title> -->
    <!-- custom css -->
    <link rel="stylesheet" href="../dashboard/dashboard.css">
    <!-- For icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="../cssfolder/election.css">
</head>

<body>
    <div class="grid-container">

        <!-- header -->
        <header class="header">
            <div class="menu-icon" onclick="openSidebar()">
                <span class="material-icons-outlined">menu</span>
            </div>
            <div class="class-left">
                <span class="material-icons-outlined"> search </span>
            </div>
        </header>
        <!-- end header -->

        <!-- slidebar -->
        <aside id="sidebar">
            <div class="sidebar-title">
                <div class="sidebar-brand">
                    <a href="dashboard.php"> <span class="material-icons-outlined"
                            style="color:#b0b2bd;">how_to_vote</span> </a>
                    Go Vote
                </div>
                <span class="material-icons-outlined" onclick="closeSidebar()">close </span>
            </div>

            <ul class="sidebar-list">
                <li class="sidebar-list-item">
                    <a href="dashboard.php"><span class="material-icons-outlined">dashboard</span> Dashboard
                </li></a>

                <li class="sidebar-list-item">
                    <a href="dashboard.php"><span class="material-icons-outlined">event_available</span> Elections
                </li></a>

                <li class="sidebar-list-item">
                    <a href="addcandidate.php"><span class="material-icons-outlined">groups</span> Candidates
                </li></a>
                <li class="sidebar-list-item"><a href="votersdetails.php"><span
                            class="material-icons-outlined">groups</span> Voterlist</li></a>
                <li class="sidebar-list-item"><a href="viewresult.php"><span
                            class="material-icons-outlined">visibility</span> View Result </a></li>

                <li class="sidebar-list-item"> <a href="notify.php"><span class="material-icons-outlined">settings </span>
                        Notify</a></li>

            </ul>
        </aside>
        <!-- Endsidebar -->

        <main class="main-container">
            <div class="form-container">
                <div class="admin-product-form-container">
                    <form action="addelection.php" method="post" enctype="multipart/form-data">
                        <h3>add a new election</h3>
                        <label for="">Election Topic</label>
                        <input type="text" name="election_topic" class="box">
                        <label for="">No Of Candidates</label>
                        <input type="number" name="number_of_candidates" class="box">
                        <label for="">Starting Date</label>
                        <input type="date" name="starting_date" class="box">
                        <label for="">Ending Date</label>
                        <input type="date" name="ending_date" class="box">
                        <input type="submit" class="btn" name="add_election" value="Add Election">
                    </form>

                    <?php
                    $fetchingData = mysqli_query($conn, "SELECT * FROM elections") or die(mysqli_error($conn));
                    $isAnyElectionAdded = mysqli_num_rows($fetchingData);

                    if ($isAnyElectionAdded > 0) {
                        ?>
                        <div class="product-display">
                            <table class="product-display-table">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Election Name</th>
                                        <th>Candidates</th>
                                        <th>Starting Date</th>
                                        <th>Ending Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sno = 1;
                                    while ($row = mysqli_fetch_assoc($fetchingData)) {
                                        $election_id = $row['election_id'];
                                        ?>
                                        <tr>
                                            <td><?php echo $sno++; ?></td>
                                            <td><?php echo $row['election_topic']; ?></td>
                                            <td><?php echo $row['no_of_candidates']; ?></td>
                                            <td><?php echo $row['starting_date']; ?></td>
                                            <td><?php echo $row['ending_date']; ?></td>
                                            <td><?php echo $row['status']; ?></td>
                                            <td>
                                                <a href="electionupdate.php?edit=<?php echo $row['election_id']; ?>"
                                                    class="box-btn"> <i class="fas fa-edit"></i> Edit </a>
                                                <a href="addelection.php?delete=<?php echo $row['election_id']; ?>"
                                                    class="box-btn"> <i class="fas fa-trash"></i> Delete </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php
                    } else {
                        ?>
                        <div style="text-align:center; margin-top:100px;">No any election is added yet.</div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </main>
    </div>

    <!-- custom js -->
    <script src="../assets/js/dashobrd.js"></script>
    <script src="../assets/js/first.js"></script>
    <script src="../assets/js/drop_down.js"></script>
</body>

</html>
