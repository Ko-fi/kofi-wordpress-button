/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './style.scss';

/**
 * Internal dependencies
 */
import Edit from './edit';
import metadata from './block.json';
import transformers from './transforms';

const kofiIcon = (
	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
	<defs>
		<mask id="mask" x=".5" y="2.77" width="23" height="18.46" maskUnits="userSpaceOnUse">
			<g id="mask0_1_219" data-name="mask0 1 219">
				<path d="M23.5,2.77H.5v18.46h23V2.77Z" fill="#fff"/>
			</g>
		</mask>
	</defs>
	<g mask="url(#mask)">
		<g>
			<path d="M9.7,21.23c-3.35,0-6.07-1.5-7.67-4.22-1.41-2.38-1.53-4.96-1.53-7.85,0-1.71.51-3.2,1.49-4.31.89-1.02,2.16-1.68,3.57-1.85,1.67-.21,3.74-.23,5.9-.23,3.51,0,4.5.04,5.88.18,1.84.18,3.38.87,4.47,1.98,1.1,1.13,1.69,2.65,1.69,4.38v.35c0,2.95-1.97,5.43-4.73,6.1-.21.48-.46.97-.76,1.44h0c-.97,1.51-3.25,4.02-7.61,4.02h-.7,0Z" fill="#fff"/>
			<path d="M17.2,4.4c-1.3-.13-2.22-.17-5.74-.17-2.26,0-4.17.02-5.72.22-2.04.26-3.78,1.83-3.78,4.72s.15,5.13,1.33,7.11c1.33,2.26,3.54,3.5,6.41,3.5h.7c3.52,0,5.44-1.87,6.39-3.35.41-.65.72-1.3.91-1.96,2.5-.22,4.35-2.28,4.35-4.81v-.35c0-2.72-1.78-4.61-4.85-4.91h0Z" fill="#fff"/>
			<path d="M1.95,9.16c0-2.89,1.74-4.46,3.78-4.72,1.54-.2,3.46-.22,5.72-.22,3.52,0,4.44.04,5.74.17,3.07.3,4.85,2.2,4.85,4.91v.35c0,2.52-1.85,4.59-4.35,4.81-.2.65-.5,1.3-.91,1.96-.96,1.48-2.87,3.35-6.39,3.35h-.7c-2.87,0-5.09-1.24-6.41-3.5-1.17-1.98-1.33-4.17-1.33-7.11" fill="#202020"/>
			<path d="M3.58,9.18c0,2.8.17,4.61,1.09,6.28,1.04,1.94,2.94,2.67,5.09,2.67h.67c2.83,0,4.2-1.37,4.96-2.57.37-.61.7-1.28.87-2.13l.13-.54h.78c1.74,0,3.24-1.41,3.24-3.22v-.33c0-2.02-1.26-3.09-3.46-3.35-1.24-.11-1.98-.15-5.5-.15-2.37,0-4.07.02-5.35.22-1.8.26-2.52,1.28-2.52,3.11" fill="#fff"/>
			<path d="M16.39,10.68c0,.26.2.46.54.46,1.11,0,1.72-.63,1.72-1.67s-.61-1.7-1.72-1.7c-.35,0-.54.2-.54.46v2.46h0Z" fill="#202020"/>
			<path d="M5.72,10.55c0,1.28.72,2.39,1.63,3.26.61.59,1.57,1.2,2.22,1.59.2.11.39.17.61.17.26,0,.48-.07.65-.17.65-.39,1.61-1,2.2-1.59.93-.87,1.65-1.98,1.65-3.26,0-1.39-1.04-2.63-2.54-2.63-.89,0-1.5.46-1.96,1.09-.41-.63-1.04-1.09-1.94-1.09-1.52,0-2.52,1.24-2.52,2.63" fill="#f15c24"/>
		</g>
	</g>
	</svg>
);

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType( metadata.name, {
	/**
	 * @see ./edit.js
	 */
	icon: kofiIcon,
	edit: Edit,
	transforms: transformers
} );
