document.addEventListener( 'DOMContentLoaded', function () {
	const images = document.querySelectorAll( 'img' );

	const observer = new IntersectionObserver( ( entries, obs ) => {
		entries.forEach( entry => {
		if ( ! entry.isIntersecting) {
			entry.target.setAttribute( 'loading', 'lazy' );
		}

		obs.unobserve( entry.target );
		} );
	} );

	images.forEach( img => observer.observe( img ) );
} );