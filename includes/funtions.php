<?php
function setCapabilities($type): array {
	$pluralType = $type . "s";
	return [
		'edit_post' => "edit_$type",
		'edit_posts' => "edit_$pluralType",
		'edit_others_posts' => "edit_other_$pluralType",
		'publish_posts' => "publish_$pluralType",
		'read_post' => "read_$type",
		'read_private_posts' => "read_private_$pluralType",
		'delete_post' => "delete_$type"
	];
}

function getCapabilities($type){
	$pluralType = $type . "s";
	return [
		"delete_$type",
		"delete_others_$type",
		"delete_private_$type",
		"delete_published_$type",
		"edit_$type",
		"edit_others_$type",
		"edit_private_$type",
		"edit_published_$type",
		"publish_$type",
		"read_private_$type",
		"delete_$pluralType",
		"delete_others_$pluralType",
		"delete_private_$pluralType",
		"delete_published_$pluralType",
		"edit_$pluralType",
		"edit_others_$pluralType",
		"edit_private_$pluralType",
		"edit_published_$pluralType",
		"publish_$pluralType",
		"read_private_$pluralType",
	];
}