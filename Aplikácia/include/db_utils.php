<?php

function execute_stm_and_fetch_all( $stm ) {
  if ( !$stm->execute() ) return [];
  $result = $stm->get_result();
  if ( $result === false ) return [];
  $results = $result->fetch_all(MYSQLI_ASSOC);
  $stm->free_result();
  $stm->close();
  return $results;
}

/* Index $data elements by the values of the $key.
 * The $key is either an index into $data elements (the elements then
 * must be indexable) or a callable, which yields an index when called
 * on a $data element.
 * Returns a new array associating $key values to the $data elements
 * with those $key values.
 * If there are more than two $data elements with the same key values,
 * only the last one is kept.
 */
function array_index_by(array &$data, $key)
{
  $assoc_array = array();
  if (is_callable($key)) {
    foreach ($data as $itemvalue) {
      $assoc_array[$key($itemvalue)] = $itemvalue;
    }
  } else {
    foreach ($data as $itemvalue) {
      $assoc_array[$itemvalue[$key]] = $itemvalue;
    }
  }
  return $assoc_array;
}

/* Group $data elements by the values of the $key.
 * The $key is either an index into $data elements (the elements then
 * must be indexable) or a callable, which yields a grouping key value
 * when called on a $data element's original index and value.
 * Returns an array associating $key values to arrays of $data elements
 * with identical $key values.
 * The inner arrays are indexed by the same indices as in the $data array.
 */
function array_group_by(array &$data, $key)
{
  $groups = array();
  if (is_callable($key)) {
    foreach ($data as $itemindex => $itemvalue) {
      $groups[$key($itemindex, $itemvalue)][$itemindex] = $itemvalue;
    }
  } else {
    foreach ($data as  $itemindex => $itemvalue) {
      $groups[$itemvalue[$key]][$itemindex] = $itemvalue;
    }
  }
  return $groups;
}
