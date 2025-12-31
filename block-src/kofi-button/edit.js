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
import { InspectorControls, useBlockProps, PanelColorSettings, BlockControls, JustifyContentControl } from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl, ToolbarGroup, ToolbarButton } from '@wordpress/components';


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
	const { code, text, color, title, button_alignment } = attributes;
	const getKofiEmbed = () => {
		kofiwidget2.init( text || kofiButtonBlock.defaultText, color || kofiButtonBlock.defaultColor, code || kofiButtonBlock.defaultCode )
		return kofiwidget2.getHTML();
	}
	const setAlignment = ( alignment ) => setAttributes({ button_alignment: alignment });
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
						placeholder={ kofiButtonBlock.defaultCode }
						value={ code || '' }
						onChange={ ( value ) =>
							setAttributes( { code: value } )
						}
					/>
					<TextControl
						__next40pxDefaultSize
						label={ __(
							'Button text',
							'ko-fi-button'
						) }
						placeholder={ kofiButtonBlock.defaultText }
						value={ text || '' }
						onChange={ ( value ) =>
							setAttributes( { text: value } )
						}
					/>
					<PanelColorSettings
						title={ __(
							'Button color', 'ko-fi-button'
						) }
						colorSettings={[{
							value: color,
							onChange: ( value ) => setAttributes( { color: value } ),
							label: __( 'Button Color', 'ko-fi-button' )
						}]}
					/>
					<TextControl
						__next40pxDefaultSize
						label={ __(
							'Hover text',
							'ko-fi-button'
						) }
						value={ title || '' }
						onChange={ ( value ) =>
							setAttributes( { title: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<BlockControls>
                <JustifyContentControl
					value={ button_alignment }
					allowedControls={ [ 'left', 'center', 'right' ] }
					onChange={ ( next ) => {
						setAttributes( { button_alignment: next } );
					} }
				/>
            </BlockControls>
			<div { ...useBlockProps( {
				className: 'wp-block-ko-fi-button-kofi-button--align-' + button_alignment
			} ) } dangerouslySetInnerHTML={{
				__html: getKofiEmbed()
			}}></div>
		</>
	);
}
