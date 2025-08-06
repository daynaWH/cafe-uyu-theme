/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {
	useBlockProps,
	InnerBlocks,
	InspectorControls,
} from "@wordpress/block-editor";
import { PanelBody, SelectControl } from "@wordpress/components";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const { animationType } = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title={__("Animation Settings", "animate-wrapper")}>
					<SelectControl
						label={__("Animation Type", "animate-wrapper")}
						value={animationType}
						options={[
							{ label: "Fade Up", value: "fade-up" },
							{ label: "Fade Down", value: "fade-down" },
							{ label: "Fade Left", value: "fade-left" },
							{ label: "Fade Right", value: "fade-right" },
						]}
						onChange={(val) => setAttributes({ animationType: val })}
					/>
				</PanelBody>
			</InspectorControls>
			<div {...useBlockProps({ "data-aos": animationType })}>
				<InnerBlocks />
			</div>
		</>
	);
}
