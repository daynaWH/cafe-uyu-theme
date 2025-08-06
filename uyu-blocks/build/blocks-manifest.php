<?php
// This file is generated. Do not modify it manually.
return array(
	'animate-wrapper' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'uyu-blocks/animate-wrapper',
		'version' => '0.1.0',
		'title' => 'Animate Wrapper',
		'category' => 'design',
		'icon' => 'editor-code',
		'description' => 'Wraps content in AOS animation.',
		'attributes' => array(
			'animationType' => array(
				'type' => 'string',
				'default' => 'fade-up'
			)
		),
		'supports' => array(
			'html' => false,
			'align' => true
		),
		'textdomain' => 'animate-wrapper',
		'editorScript' => 'file:./index.js',
		'style' => 'file:./style-index.css'
	),
	'copyright-date' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'uyu-blocks/copyright-date',
		'version' => '0.1.0',
		'title' => 'Copyright Date',
		'category' => 'text',
		'icon' => 'calendar',
		'description' => 'Display a copyright date.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false,
			'spacing' => array(
				'margin' => true,
				'padding' => true
			),
			'typography' => array(
				'fontSize' => true,
				'textAlign' => true
			),
			'color' => array(
				'text' => true,
				'background' => true
			)
		),
		'textdomain' => 'copyright-date',
		'editorScript' => 'file:./index.js',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'locations' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'uyu-blocks/locations',
		'version' => '0.1.0',
		'title' => 'Locations',
		'category' => 'widgets',
		'icon' => 'location-alt',
		'description' => 'Display all branch locations.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'locations',
		'editorScript' => 'file:./index.js',
		'style' => 'file:./style-index.css'
	),
	'menu-posts' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'uyu-blocks/menu-posts',
		'version' => '0.1.0',
		'title' => 'Menu Posts',
		'category' => 'text',
		'icon' => 'coffee',
		'description' => 'Display all menu items.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'menu-posts',
		'editorScript' => 'file:./index.js',
		'style' => 'file:./style-index.css'
	)
);
