<?php
/**
 * @package Helix_Ultimate_Framework
 * @author JoomShaper <support@joomshaper.com>
 * @copyright Copyright (c) 2010 - 2018 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */

defined('_JEXEC') or die();

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Filesystem\File;
use HelixUltimate\Framework\Platform\Helper;

/**
 * Form field for Helix font.
 *
 * @since	1.0.0
 */
class JFormFieldHelixfont extends FormField
{
	/**
	 * Field type
	 *
	 * @var		string	$type
	 * @since	1.0.0
	 */
	protected $type = 'Helixfont';

	/**
	 * Override getInput function form FormField
	 *
	 * @return	string	Field HTML string
	 * @since	1.0.0
	 */
	protected function getInput()
	{

		$input  = Factory::getApplication()->input;
		$style_id = $input->get('id', 0, 'INT');
		$style = Helper::getTemplateStyle($style_id);

		$template_path = JPATH_SITE . '/templates/' . $style->template . '/webfonts/webfonts.json';
		$plugin_path   = JPATH_PLUGINS . '/system/helixultimate/assets/webfonts/webfonts.json';

		if (file_exists($template_path))
		{
			$json = File::read($template_path);
		}
		else
		{
			$json = File::read($plugin_path);
		}

		$webfonts   = json_decode($json);
		$items      = $webfonts->items;
		$value      = json_decode($this->value);

		if (isset($value->fontFamily))
		{
			$font = self::filterArray($items, $value->fontFamily);
		}

		$html  = '';
		$classes = (!empty($this->element['class'])) ? $this->element['class'] : '';

		$systemFonts = array(
			'Arial',
			'Tahoma',
			'Verdana',
			'Helvetica',
			'Times New Roman',
			'Trebuchet MS',
			'Georgia'
		);

		$fontWeights = array(
			'100' => 'Thin',
			'200' => 'Extra Light',
			'300' => 'Light',
			'400' => 'Normal',
			'500' => 'Medium',
			'600' => 'Semi Bold',
			'700' => 'Bold',
			'800' => 'Extra Bold',
			'900' => 'Black'
		);

		$fontStyles = array(
			'normal' => 'Normal',
			'italic' => 'Italic',
			'oblique' => 'Oblique'
		);

		// Font Family
		$html .= '<div class="hu-field-webfont ' . $classes . '">';
		$html .= '<div class="row">';

		$html .= '<div class="col-12 hu-webfont-family">';
		$html .= '<label><small>' . Text::_('HELIX_ULTIMATE_FONT_FAMILY') . '</small></label>';
		$html .= '<select class="hu-webfont-list">';

		$html .= '<optgroup label="' . Text::_('HELIX_ULTIMATE_SYSTEM_FONT') . '">';

		foreach ($systemFonts as $systemFont)
		{
			$html .= '<option ' . ((isset($value->fontFamily) && $systemFont === $value->fontFamily) ? 'selected="selected"' : '') . ' value="' . $systemFont . '">' . $systemFont . '</option>';
		}

		$html .= '</optgroup>';

		$html .= '<optgroup label="' . Text::_('HELIX_ULTIMATE_GOOGLE_FONT') . '">';

		foreach ($items as $item)
		{
			$html .= '<option ' . ((isset($value->fontFamily) && $item->family === $value->fontFamily) ? 'selected="selected"' : '') . ' value="' . $item->family . '">' . $item->family . '</option>';
		}

		$html .= '</optgroup>';

		$html .= '</select>';
		$html .= '</div>';

		// Font Size
		$fontSize = (isset($value->fontSize)) ? $value->fontSize : '';
		$fontSize_sm = (isset($value->fontSize_sm)) ? $value->fontSize_sm : '';
		$fontSize_xs = (isset($value->fontSize_xs)) ? $value->fontSize_xs : '';
		$html .= '<div class="col-6 hu-webfont-size">';
		$html .= '<label><small>' . Text::_('HELIX_ULTIMATE_FONT_SIZE') . '</small></label>';
		$html .= '<div class="helix-responsive-devices">';
		// $html .= '<span data-device="md" data-active_class=".hu-webfont-size-input" class="fas fa-laptop active"></span><span data-device="sm" data-active_class=".hu-webfont-size-input-sm" class="fas fa-tablet-alt"></span><span data-device="xs" data-active_class=".hu-webfont-size-input-xs" class="fas fa-mobile-alt"></span>';
		$html .= '</div>';
		$html .= '<input type="number" value="' . $fontSize . '" class="hu-webfont-size-input active" min="6">';
		$html .= '<input type="number" value="' . $fontSize_sm . '" class="hu-webfont-size-input-sm" min="6">';
		$html .= '<input type="number" value="' . $fontSize_xs . '" class="hu-webfont-size-input-xs" min="6">';
		$html .= '</div>';

		// Font Weight
		$html .= '<div class="col-6 hu-webfont-weight">';
		$html .= '<label><small>' . Text::_('HELIX_ULTIMATE_FONT_WEIGHT') . '</small></label>';
		$html .= '<select class="hu-webfont-weight-list">';
		$html .= '<option value="">' . Text::_('HELIX_ULTIMATE_SELECT') . '</option>';

		foreach ($fontWeights as $key => $fontWeight)
		{
			if (isset($value->fontWeight) && $value->fontWeight === $key)
			{
				$html .= '<option value="' . $key . '" selected>' . $fontWeight . '</option>';
			}
			else
			{
				$html .= '<option value="' . $key . '">' . $fontWeight . '</option>';
			}
		}

		$html .= '</select>';
		$html .= '</div>';

		// Font Style
		$html .= '<div class="col-6 hu-webfont-style">';
		$html .= '<label><small>' . Text::_('HELIX_ULTIMATE_FONT_STYLE') . '</small></label>';
		$html .= '<select class="hu-webfont-style-list">';
		$html .= '<option value="">' . Text::_('HELIX_ULTIMATE_SELECT') . '</option>';

		foreach ($fontStyles as $key => $fontStyle)
		{
			if (isset($value->fontStyle) && $value->fontStyle === $key)
			{
				$html .= '<option value="' . $key . '" selected>' . $fontStyle . '</option>';
			}
			else
			{
				$html .= '<option value="' . $key . '">' . $fontStyle . '</option>';
			}
		}

		$html .= '</select>';
		$html .= '</div>';

		// Font Subsets
		$html .= '<div class="col-6 hu-webfont-subset">';
		$html .= '<label><small>' . Text::_('HELIX_ULTIMATE_FONT_SUBSET') . '</small></label>';
		$html .= '<select class="hu-webfont-subset-list">';
		$html .= '<option value="">' . Text::_('HELIX_ULTIMATE_SELECT') . '</option>';

		if (isset($value->fontFamily) && $value->fontFamily)
		{
			if (!in_array($value->fontFamily, $systemFonts))
			{
				$html .= $this->generateSelectOptions($font->subsets, $value->fontSubset);
			}
		}

		$html .= '</select>';
		$html .= '</div>';

		$html .= '</div>';

		// Preview
		$html .= '<p style="display:none" class="hu-webfont-preview">1 2 3 4 5 6 7 8 9 0 Grumpy wizards make toxic brew for the evil Queen and Jack.</p>';
		$html .= '<input type="hidden" name="' . $this->name . '" value="' . $this->value . '" class="hu-webfont-input" id="' . $this->id . '">';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Get select options for the field.
	 *
	 * @param	array	$items		The items form where the options will be generated.
	 * @param	string	$selected	The selected option item.
	 *
	 * @return	string	The option HTML string.
	 * @since	1.0.0
	 */
	private function generateSelectOptions( $items = array(), $selected = '' )
	{
		$html = '';

		foreach ($items as $item)
		{
			$html .= '<option ' . (($selected !== 'no-selection' && $item == $selected) ? 'selected="selected"' : '') . ' value="' . $item . '">' . $item . '</option>';
		}

		return $html;
	}

	/**
	 * Get Current font.
	 *
	 * @param	array	$items	The fonts array.
	 * @param	string	$key	The expected font.
	 *
	 * @return 	mixed
	 * @since	1.0.0
	 */
	private static function filterArray($items, $key)
	{
		foreach ($items as $item)
		{
			if ($item->family === $key)
			{
				return $item;
			}
		}

		return false;
	}

}
