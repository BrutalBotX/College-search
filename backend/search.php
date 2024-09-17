<?php
function readCSV($filename) {
    $rows = array_map('str_getcsv', file($filename));
    $header = array_shift($rows);
    $csv = array();
    foreach ($rows as $row) {
        $csv[] = array_combine($header, $row);
    }
    return $csv;
}

$colleges = readCSV('../database/colleges.csv');

$search = $_POST['search'] ?? '';
$maxFee = intval($_POST['maxFee'] ?? 100000);
$states = explode(',', $_POST['states'] ?? '');
$types = explode(',', $_POST['types'] ?? '');
$courses = explode(',', $_POST['courses'] ?? '');
$facilities = explode(',', $_POST['facilities'] ?? '');

$filteredColleges = array_filter($colleges, function($college) use ($search, $maxFee, $states, $types, $courses, $facilities) {
    if ($search && stripos($college['College Name'], $search) === false) {
        return false;
    }
    if (intval($college['Average Fees']) > $maxFee) {
        return false;
    }
    if (!empty($states) && !empty($states[0]) && !in_array($college['State'], $states)) {
        return false;
    }
    if (!empty($types) && !empty($types[0]) && !in_array($college['College Type'], $types)) {
        return false;
    }
    if (!empty($courses) && !empty($courses[0]) && count(array_intersect(explode(', ', $college['Courses']), $courses)) === 0) {
        return false;
    }
    if (!empty($facilities) && !empty($facilities[0]) && count(array_intersect(explode(', ', $college['Facilities']), $facilities)) === 0) {
        return false;
    }
    return true;
});

$result = array_map(function($college) {
    return [
        'name' => $college['College Name'],
        'type' => $college['College Type'],
        'state' => $college['State'],
        'fees' => intval($college['Average Fees']),
        'courses' => explode(', ', $college['Courses']),
        'facilities' => explode(', ', $college['Facilities'])
    ];
}, array_values($filteredColleges));

header('Content-Type: application/json');
echo json_encode($result);
?>