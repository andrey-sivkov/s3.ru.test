<?php
/**
 * Innova WYSIWYG HTML Editor wrapper for Smarty
 * @author Zhilin Alexey
 * @param array $params - configuration settings
 * @param link $smarty - link to Smarty object
 * @return string - HTML & JavaScript code
 */
function smarty_function_html_editor($params, &$smarty)
{		
	if (!isset($params['name']) || $params['name'] == '')
	{
		$smarty->trigger_error('html_editor: required parameter "name" is missing');
		exit();
	}
	if (!function_exists('encodeHTML'))
	{
		function encodeHTML($sHTML)
		{
			$sHTML = stripslashes($sHTML);
			$sHTML=ereg_replace("&","&amp;",$sHTML);
			$sHTML=ereg_replace("<","&lt;",$sHTML);
			$sHTML=ereg_replace(">","&gt;",$sHTML);
			return $sHTML;
		}
	}
	$tab = "\t";
	$line_break = "\r\n";
	$input_name = $params['name'];
	$asset_manager_path = $params['path'].'HTML_Editor/assetmanager/';
	$editor_name = $params['name'].'_editor';
	$editor_path = $params['path'].'HTML_Editor/scripts/';
	$editor_content = $params['content'] ? encodeHTML($params['content']) : false;
	$editor_css = $params['css'] ? $params['css'] : false;
	$editor_width = $params['width'] ? $params['width'] : false; //'531px';
	$editor_height = $params['height'] ? $params['height'] : false; //'200px';
	$editor_mode = $params['mode'] ? $params['mode'] : 'HTMLBody'; // HTMLBody | HTML | XHTMLBody | XHTML
	$btnImage = $params['btnImage'] ? $params['btnImage'] : 'false';
	$btnFlash = $params['btnFlash'] ? $params['btnFlash'] : 'false';
	$btnMedia = $params['btnMedia'] ? $params['btnMedia'] : 'false';
	$btnForm = $params['btnForm'] ? $params['btnForm'] : 'false';
	$btnStyles = $params['btnStyles'] ? $params['btnStyles'] : 'false';
	$out = '<!-- HTML EDITOR -->'.$line_break;
	$out .= '<script language="javascript" type="text/javascript" src="'.$editor_path.'innovaeditor.js"></script>'.$line_break;
	if ($editor_content)
	{
		$out .= '<textarea id="'.$input_name.'" name="'.$input_name.'" rows="4" cols="30">'.$line_break.$editor_content.$line_break.'</textarea>'.$line_break;
	}
	else 
	{
		$out .= '<textarea id="'.$input_name.'" name="'.$input_name.'" rows="4" cols="30"></textarea>'.$line_break;
	}
	$out .= '<script language="javascript" type="text/javascript">'.$line_break;
	$out .= '<!--'.$line_break;
	$out .= $tab.'var '.$editor_name.' = new InnovaEditor("'.$editor_name.'");'.$line_break;
	$out .= $tab.$editor_name.'.cmdAssetManager="modalDialogShow(\''.$asset_manager_path.'assetmanager.php\',640,445);";'.$line_break;
	$editor_width ? $out .= $tab.$editor_name.'.width = "'.$editor_width.'";'.$line_break : null;
	$editor_height ? $out .= $tab.$editor_name.'.height = "'.$editor_height.'";'.$line_break : null;
	$editor_css ? $out .= $tab.$editor_name.'.css = "'.$editor_css.'";'.$line_break : null;
	$out .= $tab.$editor_name.'.mode = "'.$editor_mode.'";'.$line_break;
	$out .= $tab.$editor_name.'.useDIV = false;'.$line_break;
	$out .= $tab.$editor_name.'.useBR = true;'.$line_break;
	$out .= $tab.$editor_name.'.btnPasteText = true;'.$line_break;
	$out .= $tab.$editor_name.'.btnImage = '.$btnImage.';'.$line_break;
	$out .= $tab.$editor_name.'.btnFlash = '.$btnFlash.';'.$line_break;
	$out .= $tab.$editor_name.'.btnMedia = '.$btnMedia.';'.$line_break;
	$out .= $tab.$editor_name.'.btnForm = '.$btnForm.';'.$line_break;
	$out .= $tab.$editor_name.'.btnStyles = '.$btnStyles.';'.$line_break;
	$out .= $tab.$editor_name.'.REPLACE("'.$input_name.'");'.$line_break;
	$out .= '-->'.$line_break;
	$out .= '</script>'.$line_break;
	$out .= '<!-- HTML EDITOR -->';
	return $out;
}
