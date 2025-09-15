document.addEventListener( 'DOMContentLoaded', function () {
	const description = document.querySelector( '.author-meta-description div' );
	const toggleLink = document.getElementById( 'toggleLink' );

	const fullText = description.textContent.replace( 'Expand', '' ).trim();
	const words = fullText.split( ' ' );

	const shortText = words.slice( 0, 50 ).join( ' ' ) + '... ';

	description.firstChild.textContent = shortText; 

	let expanded = false;
	toggleLink.addEventListener( 'click', function ( e ) {
		e.preventDefault();

		if ( expanded ) {
			description.firstChild.textContent = shortText;
			toggleLink.textContent = 'Expand';
			expanded = false;
		} else {
			description.firstChild.textContent = fullText + ' ';
			toggleLink.textContent = 'Collapse';
			expanded = true;
		}
	} );
} );