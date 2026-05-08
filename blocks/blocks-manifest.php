<?php
// This file is generated. Do not modify it manually.
return array(
	'kofi-button' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'ko-fi-button/kofi-button',
		'version' => '1.3.10',
		'title' => 'Ko-fi Donate Button',
		'category' => 'widgets',
		'description' => 'Display a donate button.',
		'example' => array(
			
		),
		'attributes' => array(
			'code' => array(
				'type' => 'string'
			),
			'text' => array(
				'type' => 'string'
			),
			'color' => array(
				'type' => 'string'
			),
			'title' => array(
				'type' => 'string'
			),
			'button_alignment' => array(
				'type' => 'string'
			)
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'ko-fi-button',
		'editorScript' => array(
			'file:./index.js',
			'ko-fi-button-widget'
		),
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	),
	'kofi-panel' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'ko-fi-button/kofi-panel',
		'version' => '1.3.10',
		'title' => 'Ko-fi Donate Panel',
		'category' => 'widgets',
		'description' => 'Display a donate panel.',
		'example' => array(
			
		),
		'attributes' => array(
			'code' => array(
				'type' => 'string'
			)
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'ko-fi-button',
		'editorScript' => array(
			'file:./index.js'
		),
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	)
);
