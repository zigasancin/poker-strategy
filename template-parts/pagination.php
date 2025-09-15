<?php
$current_page = max( 1, get_query_var( 'paged' ) );
$total_pages = $args['max_num_pages'];

$pages = paginate_links(
	array(
		'current'   => $current_page,
		'total'     => $total_pages,
		'type'      => 'array',
		'prev_text' => '<',
		'next_text' => '>'
	)
);

if ( is_array( $pages ) ) {
	echo '<nav class="pagination"><ul>';

	if ( $current_page > 1 ) {
		echo '<li><a class="page-numbers first" href="' . esc_url( get_pagenum_link( 1 ) ) . '">|< First</a></li>';
	}

	foreach ( $pages as $page ) {
		echo '<li>' . $page . '</li>';
	}

	if ( $current_page < $total_pages ) {
		echo '<li><a class="page-numbers last" href="' . esc_url( get_pagenum_link( $total_pages ) ) . '">Last (' . $total_pages . ') >|</a></li>';
	}

	echo '</ul></nav>';
}