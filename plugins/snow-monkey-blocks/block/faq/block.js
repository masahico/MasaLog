'use strict';

import generateUpdatedAttribute from '../../src/js/helper/generate-updated-attribute';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

const { get, times } = lodash;
const { registerBlockType } = wp.blocks;
const { RichText, InspectorControls, ColorPalette } = wp.editor;
const { PanelBody, RangeControl, BaseControl } = wp.components;
const { Fragment } = wp.element;
const { __, sprintf } = wp.i18n;

registerBlockType( 'snow-monkey-blocks/faq', {
	title: __( 'FAQ', 'snow-monkey-blocks' ),
	icon: 'businessman',
	category: 'smb',
	attributes: {
		content: {
			type: 'array',
			source: 'query',
			selector: '.smb-faq__item',
			default: [],
			query: {
				question: {
					source: 'html',
					selector: '.smb-faq__item__question__body',
				},
				answer: {
					source: 'html',
					selector: '.smb-faq__item__answer__body',
				},
				questionColor: {
					type: 'string',
					default: null,
					source: 'attribute',
					selector: '.smb-faq__item__question__label',
					attribute: 'data-color',
				},
				answerColor: {
					type: 'string',
					default: null,
					source: 'attribute',
					selector: '.smb-faq__item__answer__label',
					attribute: 'data-color',
				},
			},
		},
		rows: {
			type: 'number',
			default: 1,
		},
	},

	edit( { attributes, setAttributes, isSelected } ) {
		const { rows, content } = attributes;

		return (
			<Fragment>
				<InspectorControls>
					<PanelBody title={ __( 'FAQ Settings', 'snow-monkey-blocks' ) }>
						<RangeControl
							label={ __( 'Rows', 'snow-monkey-blocks' ) }
							value={ rows }
							onChange={ ( value ) => setAttributes( { rows: value } ) }
							min="1"
							max="50"
						/>
					</PanelBody>

					{ times( rows, ( index ) => {
						const questionColor = get( content, [ index, 'questionColor' ], '' );
						const answerColor = get( content, [ index, 'answerColor' ], '' );

						return (
							<PanelBody
								title={ sprintf( __( '(%d) Item Settings', 'snow-monkey-blocks' ), index + 1 ) }
								initialOpen={ false }
							>
								<BaseControl label={ __( 'Question Color', 'snow-monkey-blocks' ) }>
									<ColorPalette
										value={ questionColor }
										onChange={ ( value ) => setAttributes( { content: generateUpdatedAttribute( content, index, 'questionColor', value ) } ) }
									/>
								</BaseControl>

								<BaseControl label={ __( 'Answer Color', 'snow-monkey-blocks' ) }>
									<ColorPalette
										value={ answerColor }
										onChange={ ( value ) => setAttributes( { content: generateUpdatedAttribute( content, index, 'answerColor', value ) } ) }
									/>
								</BaseControl>
							</PanelBody>
						);
					} ) }
				</InspectorControls>

				<div className="smb-faq">
					<div className="smb-faq__body">
						{ times( rows, ( index ) => {
							const question = get( content, [ index, 'question' ], '' );
							const answer = get( content, [ index, 'answer' ], '' );
							const questionColor = get( content, [ index, 'questionColor' ], '' );
							const answerColor = get( content, [ index, 'answerColor' ], '' );

							return (
								<div className="smb-faq__item">
									<div className="smb-faq__item__question">
										<div className="smb-faq__item__question__label" style={ { color: questionColor } } data-color={ questionColor }>
											Q
										</div>
										<RichText
											className="smb-faq__item__question__body"
											placeholder={ __( 'Write question...', 'snow-monkey-blocks' ) }
											value={ question }
											formattingControls={ [] }
											multiline={ false }
											onChange={ ( value ) => setAttributes( { content: generateUpdatedAttribute( content, index, 'question', value ) } ) }
										/>
									</div>

									<div className="smb-faq__item__answer">
										<div className="smb-faq__item__answer__label" style={ { color: answerColor } } data-color={ answerColor }>
											A
										</div>
										<RichText
											className="smb-faq__item__answer__body"
											placeholder={ __( 'Write answer...', 'snow-monkey-blocks' ) }
											value={ answer }
											multiline="p"
											onChange={ ( value ) => setAttributes( { content: generateUpdatedAttribute( content, index, 'answer', value ) } ) }
										/>
									</div>
								</div>
							);
						} ) }
					</div>

					{ isSelected &&
						<div className="smb-add-item-button-wrapper">
							{ rows > 1 &&
								<button className="smb-remove-item-button" onClick={ () => setAttributes( { rows: rows - 1 } ) }>
									<FontAwesomeIcon icon="minus-circle" />
								</button>
							}

							<button className="smb-add-item-button" onClick={ () => setAttributes( { rows: rows + 1 } ) }>
								<FontAwesomeIcon icon="plus-circle" />
							</button>
						</div>
					}
				</div>
			</Fragment>
		);
	},

	save( { attributes } ) {
		const { rows, content } = attributes;

		return (
			<div className="smb-faq">
				<div className="smb-faq__body">
					{ times( rows, ( index ) => {
						const question = get( content, [ index, 'question' ], '' );
						const answer = get( content, [ index, 'answer' ], '' );
						const questionColor = get( content, [ index, 'questionColor' ], '' );
						const answerColor = get( content, [ index, 'answerColor' ], '' );

						return (
							<div className="smb-faq__item">
								<div className="smb-faq__item__question">
									<div className="smb-faq__item__question__label" style={ { color: questionColor } } data-color={ questionColor }>
										Q
									</div>
									<div className="smb-faq__item__question__body">
										<RichText.Content value={ question } />
									</div>
								</div>

								<div className="smb-faq__item__answer">
									<div className="smb-faq__item__answer__label" style={ { color: answerColor } } data-color={ answerColor }>
										A
									</div>
									<div className="smb-faq__item__answer__body">
										<RichText.Content value={ answer } />
									</div>
								</div>
							</div>
						);
					} ) }
				</div>
			</div>
		);
	},
} );
