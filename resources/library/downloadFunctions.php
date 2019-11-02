<?php

function arrayToCSV($array, $filename = "export.csv")
{
  header('Content-Type: application/csv');
  header('Content-Disposition: attachment; filename="'.$filename.'";');

  $f = fopen('php://output', 'w');
  fputcsv($f, array_keys($array[0]));

  foreach ($array as $line) {
        fputcsv($f, $line, ',');
    }
}
