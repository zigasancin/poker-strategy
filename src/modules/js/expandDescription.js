document.addEventListener( 'DOMContentLoaded', function () {
	const description = document.querySelector( '.author-meta-description div' );
	const toggleLink = document.getElementById( 'toggleLink' );

	const fullText = description.textContent.replace( 'Expand', '' ).trim();
	const words = fullText.split( ' ' );

	const shortText = words.slice( 0, 50 ).join( ' ' ) + '... ';

	description.firstChild.textContent = shortText; 

	toggleLink.addEventListener( 'click', function ( e ) {
		e.preventDefault();

		const expanded = toggleLink.getAttribute( 'aria-expanded' ) === 'true';

		if ( expanded ) {
			description.firstChild.textContent = shortText;
			toggleLink.setAttribute( 'aria-expanded', 'false' );
			toggleLink.textContent = 'Expand';
		} else {
			description.firstChild.textContent = fullText + ' ';
			toggleLink.setAttribute( 'aria-expanded', "true" );
			toggleLink.textContent = 'Collapse';
		}
	} );
} );