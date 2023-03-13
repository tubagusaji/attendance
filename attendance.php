<!DOCTYPE html>
<html>
<head>
    <title>Attendance System</title>
</head>
<body>
    <h1>Attendance System</h1>

    <form method="post" action="">
        <label for="name">Employee Name:</label>
        <input type="text" id="name" name="name" required>
        <br><br>
        <input type="submit" name="attendance" value="Attendance">
        <input type="submit" name="time_out" value="Time Out">
    </form>

    <?php
    // Konfigurasi database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "attendance";

    // Koneksi ke database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Jika tombol Attendance ditekan
    if (isset($_POST["attendance"])) {
        $name = $_POST["name"];
        record_attendance($name);
        echo "<p>$name has been recorded as attended.</p>";
    }

    // Jika tombol Time Out ditekan
    if (isset($_POST["time_out"])) {
        $name = $_POST["name"];
        record_time_out($name);
        echo "<p>$name has been recorded as time out.</p>";

        $late_time = calculate_late_time($name);
        $early_time = calculate_early_time($name);
        $overtime = calculate_overtime($name);

        echo "<p>Late Time: $late_time minutes</p>";
        echo "<p>Early Time: $early_time minutes</p>";
        echo "<p>Overtime: $overtime minutes</p>";
    }

    // Fungsi untuk mencatat kehadiran
    function record_attendance($name) {
        // Mendapatkan waktu saat ini
        $date = date("Y-m-d");
        $time_in = date("H:i:s");

        // Menambahkan record kehadiran ke database
        global $conn;
        $sql = "INSERT INTO attendance_records (employee_name, date, time_in) VALUES ('$name', '$date', '$time_in')";
        $conn->query($sql);
    }

    // Fungsi untuk mencatat waktu pulang
    function record_time_out($name) {
        // Mendapatkan waktu saat ini
        $date = date("Y-m-d");
        $time_out = date("H:i:s");

        // Mengupdate record kehadiran dengan waktu pulang
        global $conn;
        $sql = "UPDATE attendance_records SET time_out = '$time_out' WHERE employee_name = '$name' AND date = '$date'";
        $conn->query($sql);
    }

    // Fungsi untuk menghitung jumlah keterlambatan
    function calculate_late_time($name) {
        // Mendapatkan waktu masuk
        global $conn;
        $sql = "SELECT time_in FROM attendance_records WHERE employee_name = '$name' ORDER BY date DESC LIMIT 1";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $time_in = $row["time_in"];

        // Menghitung selisih waktu
        $expected_time_in = strtotime("08:00:00");
        $late_time = (strtotime($time_in) - $expected_time_in) / 60;

        return max(0, $late_time);
    }

    // Fungsi untuk menghitung jumlah pulang cepat
function calculate_early_time($name) {
    // Mendapatkan waktu pulang
    global $conn;
    $sql = "SELECT time_out FROM attendance_records WHERE employee_name = '$name' ORDER BY date DESC LIMIT 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $time_out = $row["time_out"];

    // Menghitung selisih waktu
    $expected_time_out = strtotime("17:00:00");
    $early_time = ($expected_time_out - strtotime($time_out)) / 60;

    return max(0, $early_time);
}

// Fungsi untuk menghitung jumlah lembur
function calculate_overtime($name) {
    // Mendapatkan waktu masuk dan pulang terakhir
    global $conn;
    $sql = "SELECT time_in, time_out FROM attendance_records WHERE employee_name = '$name' ORDER BY date DESC LIMIT 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $time_in = $row["time_in"];
    $time_out = $row["time_out"];

    // Menghitung selisih waktu
    $expected_time_out = strtotime("17:00:00");
    $overtime = (strtotime($time_out) - $expected_time_out) / 60;

    return max(0, $overtime);
}
?>
</body>
</html>
