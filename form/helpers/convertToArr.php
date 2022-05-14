<?php

function convertToArr($data)
{
  $converted = [];
  foreach ($data as $key => $value) {
    $converted[] = $value;
  }
  return $converted;
}