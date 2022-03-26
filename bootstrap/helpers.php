<?php
function filterDetailResults($detail)
{
  $resultFix = [];

  for ($i = 0; $i < count($detail); $i++) {
    // skip same criteria
    if ($detail[$i]->criteria_id_first === $detail[$i]->criteria_id_second) {
      continue;
    }

    // is any first criteria id on second criteria id
    $isAnyFirstCriteria = searchArray($resultFix, 'criteria_id_second', $detail[$i]->criteria_id_first);

    // is any second criteria id on first criteria id
    $isAnySecondCriteria = searchArray($resultFix, 'criteria_id_first', $detail[$i]->criteria_id_second);

    // check if any previous comparison of criteria
    $prevComparison = false;

    if ($isAnyFirstCriteria && $isAnySecondCriteria) {
      $prevComparison = true;
    }

    // insert to resultFix if there's no previous comparisons
    if ($prevComparison === false) {
      array_push($resultFix, $detail[$i]);
    }
  }

  return $resultFix;
}

function searchArray($arrayName, $keyName, $valueName)
{
  return in_array($valueName, array_column($arrayName, $keyName));
}
