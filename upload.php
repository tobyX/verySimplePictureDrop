<?php

$uploadDir = './'; // change to dir you want to store your pictures

$name = $_POST['name'];

$name = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).])", '', $name);
$name = preg_replace("([\.]{2,})", '', $name);
$name = strtolower($name);

if (empty($name))
	return;

if (!is_dir($uploadDir . '/' . $name))
	mkdir($uploadDir . '/' . $name);

$path = realpath($uploadDir . '/' . $name);

foreach ($_FILES as $file)
{
	if (stripos($file['type'], 'image') !== 0)
		continue;

	$fname = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).])", '', $file['name']);
	$fname = preg_replace("([\.]{2,})", '', $fname);

	// do not overwrite files
	if (file_exists($path . '/'. $fname))
	{
		$h = explode('.', $fname);
		$ext = array_pop($h);
		$f = implode('', $h);

		$f .= '_0';

		while (file_exists($path . '/'. $f . '.' . $ext))
			$f++;

		$fname = $f . '.' . $ext;
	}

	move_uploaded_file($file['tmp_name'], $path . '/'. $fname);
}