<?php /** * @version * @package		Joomla.Site * @subpackage	tpl_alls * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved. * @license		GNU General Public License version 2 or later */ // No direct access.
defined('_JEXEC') or die;

 /** * allsDivision chrome. * * @since	1.6 */
function modChrome_beezDivision($module, &$params, &$attribs)
{
	$headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
	if (!empty ($module->content)) { ?>
<div class="moduletable<?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
<?php if ($module->showtitle) { ?> <h<?php echo $headerLevel; ?>><span
	class="backh"><span class="backh2"><span class="backh3"><?php echo $module->title; ?></span></span></span></h<?php echo $headerLevel; ?>>
<?php }; ?> <?php echo $module->content; ?></div>
<?php };
}

/**
 * beezHide chrome.
 *
 * @since	1.6
 */
function modChrome_beezHide($module, &$params, &$attribs)
{
	$headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
	$state=isset($attribs['state']) ? (int) $attribs['state'] :0;

	if (!empty ($module->content)) { ?>

<div
	class="moduletable_js <?php echo htmlspecialchars($params->get('moduleclass_sfx'));?>"><?php if ($module->showtitle) : ?>
<h<?php echo $headerLevel; ?> class="js_heading"><span class="backh"> <span
	class="backh1"><?php echo $module->title; ?> <a href="#"
	title="<?php echo JText::_('TPL_BEEZ5_CLICK'); ?>"
	onclick="auf('module_<?php echo $module->id; ?>'); return false"
	class="opencloselink" id="link_<?php echo $module->id?>"> <span
	class="no"><img src="templates/beez_20/images/plus.png"
	alt="<?php if ($state == 1) { echo JText::_('TPL_BEEZ5_ISOPEN');} else {echo JText::_('TPL_BEEZ5_ISCLOSED');} ?>" />
</span></a></span></span></h<?php echo $headerLevel; ?>> <?php endif; ?>
<div class="module_content <?php if ($state==1){echo "open";} ?>"
	id="module_<?php echo $module->id; ?>" tabindex="-1"><?php echo $module->content; ?></div>
</div>
	<?php }
}

/**
 * beezTabs chrome.
 *
 * @since	1.6
 */
function modChrome_beezTabs($module, $params, $attribs)
{
	$area = isset($attribs['id']) ? (int) $attribs['id'] :'1';
	$area = 'area-'.$area;

	static $modulecount;
	static $modules;

	if ($modulecount < 1) {
		$modulecount = count(JModuleHelper::getModules($attribs['name']));
		$modules = array();
	}

	if ($modulecount == 1) {
		$temp = new stdClass();
		$temp->content = $module->content;
		$temp->title = $module->title;
		$temp->params = $module->params;
		$temp->id=$module->id;
		$modules[] = $temp;
		// list of moduletitles
		// list of moduletitles
		echo '<div id="'. $area.'" class="tabouter"><ul class="tabs">';

		foreach($modules as $rendermodule) {
			echo '<li class="tab"><a href="#" id="link_'.$rendermodule->id.'" class="linkopen" onclick="tabshow(\'module_'. $rendermodule->id.'\');return false">'.$rendermodule->title.'</a></li>';
		}
		echo '</ul>';
		$counter=0;
		// modulecontent
		foreach($modules as $rendermodule) {
			$counter ++;

			echo '<div tabindex="-1" class="tabcontent tabopen" id="module_'.$rendermodule->id.'">';
			echo $rendermodule->content;
			if ($counter!= count($modules))
			{
			echo '<a href="#" class="unseen" onclick="nexttab(\'module_'. $rendermodule->id.'\');return false;" id="next_'.$rendermodule->id.'">'.JText::_('TPL_BEEZ2_NEXTTAB').'</a>';
			}
			echo '</div>';
		}
		$modulecount--;
		echo '</div>';
	} else {
		$temp = new stdClass();
		$temp->content = $module->content;
		$temp->params = $module->params;
		$temp->title = $module->title;
		$temp->id = $module->id;
		$modules[] = $temp;
		$modulecount--;
	}
}
