<?php
/**
 * Pluralizes class names
 * TODO: add dictionary-based pluralization
 * @param string $word Word to pluralize
 * @return string Pluralized word
 */
function plural($word){
  return $word.'s';
}

/**
 * Singularizes class names
 * @param string $word 
 * @return type 
 */
function singular($word) {
  return trim($word, 's');
}