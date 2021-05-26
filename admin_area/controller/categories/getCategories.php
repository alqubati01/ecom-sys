<?php

require_once '../../include/connection.php';
session_start();

function buildTree(array $elements, $options = [
    'parent_id_column_slug' => 'parent_id', 
    'children_key_slug' => 'children',
    'id_column_slug' => 'id' ], $parentId = 0)
{
    $branch = array();
    foreach ($elements as $element) {
        if ($element[$options['parent_id_column_slug']] == $parentId) {
            $children = buildTree($elements, $options, $element[$options['id_column_slug']]);
            if ($children) {
                $element[$options['children_key_slug']] = $children;
            }
            $branch[] = $element;
        }
    }
    return $branch;
} 

$stmt = $pdo->prepare('SELECT id, parent_id, slug AS text, is_active FROM categories');
$stmt->execute();

while( $row = $stmt->fetch() ) {
    $row['text'] = ( $row['text'] );
    if ( $row['is_active'] == 0){
        $row['icon']  = 'icon ni ni-folder-fill text-danger';
    }
    $row['a_attr'] =  array (
        'id' => $row['id'],
        'text' => $row['text'],
    );
    $data_array[] = $row;
} 

echo json_encode(buildTree($data_array));