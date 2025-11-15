<?php
if (isset($_POST['submit'])) {
    $stmt = $conn->prepare("SELECT * FROM activity WHERE Date=:date AND ID=:id AND `Time Out`=''");
    $stmt->bindParam(':date', $_POST['date']);
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->execute();
    $activity = $stmt->fetchAll();
    if (count($activity) == 0) {
        try {
            $id = (int)$_POST['id'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $program = $_POST['program'];
            $year_level = $_POST['year_level'];
            $time_in = $_POST['time'];
            $date = $_POST['date'];

            $stmt = $conn->prepare("INSERT INTO activity (`ID`, `First Name`, `Last Name`, `Program`, `Year Level`, `Time In`, `Date`) VALUES (:id, :first_name, :last_name, :program, :year_level, :time_in, :date)");

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':program', $program);
            $stmt->bindParam(':year_level', $year_level);
            $stmt->bindParam(':time_in', $time_in);
            $stmt->bindParam(':date', $date);

            $stmt->execute();

            $stmt = $conn->prepare("UPDATE `students` SET `visits` = `visits` + 1 WHERE `ID` = $id");
            $stmt->execute();
            echo "
                        <div class='alert alert-success alert-dismissible fade show d-flex align-items-center' role='alert'>
                            <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Success:''><use xlink:href='#check-circle-fill'/></svg>
                            <div>
                                Time in successfully!
                            </div>
                        </div>
                    ";
        } catch (PDOException $e) {
            echo "
                        <div class='alert alert-danger alert-dismissible fade show d-flex align-items-center' role='alert'>
                            <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                            <div>
                                Time in failed!
                            </div>
                        </div>
                    ";
        }
    } else if (count($activity) == 1) {
        try {
            $time_out = $_POST['time'];
            foreach ($activity as $activity) {
                $activity_id = $activity['activity_id'];
            }
            $stmt = $conn->prepare("UPDATE `activity` SET `Time Out`=:time_out WHERE activity_id=:activity_id");
            $stmt->bindParam(':time_out', $time_out);
            $stmt->bindParam(':activity_id', $activity_id);
            $stmt->execute();
            echo "
                        <div class='alert alert-success alert-dismissible fade show d-flex align-items-center' role='alert'>
                            <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Success:''><use xlink:href='#check-circle-fill'/></svg>
                            <div>
                                Time out successfully!
                            </div>
                        </div>
                    ";
        } catch (PDOException $e) {
            echo "
                        <div class='alert alert-danger alert-dismissible fade show d-flex align-items-center' role='alert'>
                            <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Success:'><use xlink:href='#check-circle-fill'/></svg>
                            <div>
                                Time out failed!
                            </div>
                        </div>
                    ";
        }
    } else {
        echo "
                    <div class='alert alert-danger alert-dismissible fade show d-flex align-items-center' role='alert'>
                        <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Success:'><use xlink:href='#check-circle-fill'/></svg>
                        <div>
                            Time failed!
                        </div>
                    </div>
                ";
    }
}
