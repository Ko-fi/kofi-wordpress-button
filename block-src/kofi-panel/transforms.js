import { createBlock } from '@wordpress/blocks';
import { next } from '@wordpress/shortcode';

const transformers = {
	to: [],
	from: [
		{
			type: 'block',
			blocks: [ 'core/shortcode' ],
			isMatch: ( { text } ) => {
				let _return = false;
				let shortcodeObj = next( 'kofi', text );
				if ( shortcodeObj ) {
					// It is a Ko-fi shortcode.
					if ( shortcodeObj.shortcode.attrs.named.type && shortcodeObj.shortcode.attrs.named.type === 'panel' ) {
						// It is a panel shortcode.
						_return = true;
					}
				}
				return _return;
			},
			transform: ( { text } ) => {
				let shortcodeObj = next( 'kofi', text );
				return createBlock( 'ko-fi-button/kofi-panel', shortcodeObj.shortcode.attrs.named );
			}
		},
		{
			type: 'shortcode',
			tag: 'kofi',
			isMatch: ( { named } ) => {
				if ( named.type && named.type === 'panel' ) {
					return true;
				} else {
					return false;
				}
			},
			transform: ( { named } ) => {
				return createBlock( 'ko-fi-button/kofi-panel', named );
			}
		},
		{
			type: 'block',
			blocks: [ 'core/legacy-widget' ],
			isMatch: ( { idBase, instance } ) => {
				return idBase === 'ko_fi_panel_widget';
			},
			transform: ( { instance } ) => {
				return createBlock( 'ko-fi-button/kofi-panel', {
					code: instance.raw.code
				});
			}
		}
	],
};
export default transformers;
