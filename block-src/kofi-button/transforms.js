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
					if ( ! shortcodeObj.shortcode.attrs.named.type || shortcodeObj.shortcode.attrs.named.type === 'button' ) {
						// It is a button shortcode.
						_return = true;
					}
				}
				return _return;
			},
			transform: ( { text } ) => {
				let shortcodeObj = next( 'kofi', text );
				return createBlock( 'ko-fi-button/kofi-button', shortcodeObj.shortcode.attrs.named );
			}
		},
		{
			type: 'shortcode',
			tag: 'kofi',
			isMatch: ( { named } ) => {
				if ( ! named.type || named.type === 'button' ) {
					return true;
				} else {
					return false;
				}
			},
			transform: ( { named } ) => {
				return createBlock( 'ko-fi-button/kofi-button', named );
			}
		},
		{
			type: 'block',
			blocks: [ 'core/legacy-widget' ],
			isMatch: ( { idBase, instance } ) => {
				return idBase === 'ko_fi_widget';
			},
			transform: ( { instance } ) => {
				return createBlock( 'ko-fi-button/kofi-button', {
					code: instance.raw.code,
					color: instance.raw.color,
					title: instance.raw.html_title,
					text: instance.raw.text,
					button_alignment: instance.raw.button_alignment
				});
			}
		}
	],
};
export default transformers;
