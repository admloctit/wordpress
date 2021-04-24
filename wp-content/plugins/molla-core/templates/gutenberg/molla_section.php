<?php

extract(
	shortcode_atts(
		array(
			'wrapper'   => 'container',
			'className' => '',
		),
		$atts
	)
);
echo '<div class="section' . ( $className ? ' ' . $className : '' ) . '"><div class="' . $wrapper . '">' . $content . '</div></div>';
