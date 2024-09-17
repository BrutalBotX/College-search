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

$states = array_unique(array_column($colleges, 'State'));
$courses = array_unique(
    array_reduce($colleges, function($carry, $college) {
        return array_merge($carry, explode(', ', $college['Courses']));
    }, [])
);
$facilities = array_unique(
    array_reduce($colleges, function($carry, $college) {
        return array_merge($carry, explode(', ', $college['Facilities']));
    }, [])
);

$filters = [
    'states' => $states,
    'courses' => $courses,
    'facilities' => $facilities
];

header('Content-Type: application/json');
echo json_encode($filters);
?>