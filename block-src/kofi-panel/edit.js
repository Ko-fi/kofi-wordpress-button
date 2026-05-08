import { useState } from 'react';

/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { InspectorControls, useBlockProps, PanelColorSettings } from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl } from '@wordpress/components';


/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	const { code } = attributes;
	const getKofiPanelIframe = () => {
		return '<iframe id="kofiframe" src="https://ko-fi.com/' + ( code || kofiPanelBlock.defaultCode ) + '/?hidefeed=true&widget=true&embed=true&preview=true" style="border:none;width:100%;padding:4px;background:#f9f9f9;display:block;" height="712" title="%1$s"></iframe>'
	}
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'ko-fi-button' ) }>
					<TextControl
						__next40pxDefaultSize
						label={ __(
							'Page name or ID',
							'ko-fi-button'
						) }
						placeholder={ kofiPanelBlock.defaultCode }
						value={ code || '' }
						onChange={ ( value ) =>
							setAttributes( { code: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps() } dangerouslySetInnerHTML={{
				__html: getKofiPanelIframe()
			}}></div>
		</>
	);
}
