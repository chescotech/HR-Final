
<?php
// session_start();
include_once '../Classes/Timesheets.php';

$TimesheetObject = new Timesheets($link);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the raw JSON data from the request body
    $json_data = file_get_contents("php://input");

    // Decode the JSON data into an associative array
    $post_data = json_decode($json_data, true);

    // Access the parsed values from the decoded data
    $currentDate = $post_data["date"];
    $currentPage = $post_data["page"];
    $entries = $post_data["entries"];
    $timesheet_id = $_SESSION['timesheet_id'];

    $day_id = $TimesheetObject->saveDay($currentDate, $timesheet_id);

    // Insert the entries into the database for the current day (page)
    foreach ($entries as $entry) {
        // $entry is an associative array, so you can access its properties like this
        $start_time = date("H:i:s", strtotime($entry['start_time']));
        $end_time = date("H:i:s", strtotime($entry['end_time']));
        $hours = $entry['hours'];
        $note = $entry['note'];

        $result = $TimesheetObject->saveDayEntries($day_id, $start_time, $end_time, $hours, $note, $timesheet_id);
    }

    // Determine whether there are more pages to process
    // can be done by checking if current day is same as last day
    $hasMorePages = $TimesheetObject->hasMoreDays($timesheet_id, $currentDate);

    // Return a response indicating whether there are more pages
    $response = [
        "hasMorePages" => $hasMorePages,
    ];

    header("Content-Type: application/json");
    echo json_encode($response);
} else {
    // Handle invalid requests or other HTTP methods
    http_response_code(400); // Bad Request
}
?>