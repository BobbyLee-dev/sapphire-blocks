/**
 * BLOCK: sapphire-blocks
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import './editor.scss';
import './style.scss';

// Import Icons
import recipeIcons from './recipeIcons';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { RichText, InnerBlocks, BlockList } = wp.editor;
// console.log(wp.editor);

/**
 * Register: aa Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType('sapphire-blocks/recipe', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __('Sapphire Recipe'), // Block title.
	icon: recipeIcons.soupSpoon, // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'sapphire-blocks', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [__('Sapphire Blocks'), __('Recipe'), __('Cooking'), __('Food')],
	attributes: {
		servingSize: {
			type: 'string',
			source: 'html',
			selector: '.serving-size',
		},
		prepTime: {
			type: 'string',
			source: 'html',
			selector: '.prep-time',
		},
		cookTime: {
			type: 'string',
			source: 'html',
			selector: '.cook-time',
		},
		ingredients: {
			type: 'string',
			source: 'html',
			selector: '.ingredients',
		},
	},

	/**
	 * The edit function describes the structure of your block in the context of the editor.
	 * This represents what the editor will render when the block is used.
	 *
	 * The "edit" property must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 *
	 * @param {Object} props Props.
	 * @returns {Mixed} JSX Component.
	 */
	edit: (props) => {
		const onChangeServingSize = (newServingSize) => {
			props.setAttributes({ servingSize: newServingSize });
		};

		const onChangePrepTime = (newPrepTime) => {
			props.setAttributes({ prepTime: newPrepTime });
		};

		const onChangeCookTime = (newCookTime) => {
			props.setAttributes({ cookTime: newCookTime });
		};

		const onChangeIngredients = (newIngredient) => {
			props.setAttributes({ ingredients: newIngredient });
		};

		return (
			<div className={props.className}>
				<div className="recipe-meta">
					<div className="serving-size-wrap">
						<div className="recipe-icon">{recipeIcons.soupSpoon}</div>
						<div className="serving-size">
							<RichText
								placeholder="Serving Size"
								value={props.attributes.servingSize}
								onChange={onChangeServingSize}
							/>
						</div>
					</div>
					<div className="prep-time-wrap">
						<div className="recipe-icon">{recipeIcons.apron}</div>
						<div className="prep-time">
							<RichText placeholder="Prep Time" value={props.attributes.prepTime} onChange={onChangePrepTime} />
						</div>
					</div>
					<div className="cook-time-wrap">
						<div className="recipe-icon">{recipeIcons.pan}</div>
						<div className="cook-time-wrap">
							<RichText placeholder="Cook Time" value={props.attributes.cookTime} onChange={onChangeCookTime} />
						</div>
					</div>
				</div>
				{/* <BlockList /> */}
				{/* <InnerBlocks placeholder="Ingredients" allowedBlocks={ [ 'core/list' ] } /> */}
				<RichText
					tagName="ul"
					multiline="li"
					placeholder={__('Ingredients', 'sapphire-blocks')}
					onChange={onChangeIngredients}
					value={props.attributes.ingredients}
				/>
			</div>
		);
	},

	/**
	 * The save function defines the way in which the different attributes should be combined
	 * into the final markup, which is then serialized by Gutenberg into post_content.
	 *
	 * The "save" property must be specified and must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 *
	 * @param {Object} props Props.
	 * @returns {Mixed} JSX Frontend HTML.
	 */
	save: (props) => {
		return (
			<div className={props.className}>
				<div className="recipe-meta">
					<div className="serving-size-wrap">
						<div className="recipe-icon">{recipeIcons.soupSpoon}</div>
						<div className="serving-size">
							<RichText.Content value={props.attributes.servingSize} />
						</div>
					</div>
					<div className="prep-time-wrap">
						<div className="recipe-icon">{recipeIcons.apron}</div>
						<div className="prep-time">
							<RichText.Content value={props.attributes.prepTime} />
						</div>
					</div>
					<div className="cook-time-wrap">
						<div className="recipe-icon">{recipeIcons.pan}</div>
						<div className="cook-time">
							<RichText.Content value={props.attributes.cookTime} />
						</div>
					</div>
					<div className="ingredients">
						<RichText.Content value={props.attributes.ingredients} />
					</div>
				</div>
				{/* <InnerBlocks placeholder="Ingredients" allowedBlocks={ [ 'core/list' ] } /> */}
			</div>
		);
	},
});
