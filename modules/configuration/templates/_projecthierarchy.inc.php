<table style="width: 790px;" cellpadding=0 cellspacing=0>
	<tr>
		<td style="padding-right: 5px;">
			<div class="config_header nobg"><b><?php echo __('Editions'); ?></b></div>
			<?php if ($access_level == configurationActions::ACCESS_FULL): ?>
				<form accept-charset="<?php echo TBGContext::getI18n()->getCharset(); ?>" action="<?php echo make_url('configure_projects_add_edition', array('project_id' => $project->getID())); ?>" method="post" id="add_edition_form" onsubmit="addEdition('<?php echo make_url('configure_projects_add_edition', array('project_id' => $project->getID())); ?>');return false;" <?php if (!$project->isEditionsEnabled()): ?> style="display: none;"<?php endif; ?>>
					<div class="rounded_box lightyellow" style="vertical-align: middle; padding: 5px; font-size: 12px;">
						<input type="submit" value="<?php echo __('Add'); ?>" style="float: right;">
						<label for="edition_name"><?php echo __('Add an edition'); ?></label>
						<input type="text" id="edition_name" name="e_name" style="width: 175px;">
					</div>
					<table cellpadding=0 cellspacing=0 style="display: none; margin-left: 5px; width: 300px;" id="edition_add_indicator">
						<tr>
							<td style="width: 20px; padding: 2px;"><?php echo image_tag('spinning_20.gif'); ?></td>
							<td style="padding: 0px; text-align: left;"><?php echo __('Adding edition, please wait'); ?>...</td>
						</tr>
					</table>
				</form>
			<?php endif; ?>
		</td>
		<td style="padding-right: 5px;">
			<div class="config_header nobg"><b><?php echo __('Components'); ?></b></div>
			<?php if ($access_level == configurationActions::ACCESS_FULL): ?>
				<form accept-charset="<?php echo TBGContext::getI18n()->getCharset(); ?>" action="<?php echo make_url('configure_projects_add_component', array('project_id' => $project->getID())); ?>" method="post" id="add_component_form" onsubmit="addComponent('<?php echo make_url('configure_projects_add_component', array('project_id' => $project->getID())); ?>');return false;"<?php if (!$project->isComponentsEnabled()): ?> style="display: none;"<?php endif; ?>>
					<div class="rounded_box lightyellow" style="vertical-align: middle; padding: 5px; font-size: 12px;">
						<input type="submit" value="<?php echo __('Add'); ?>" style="float: right;">
						<label for="component_name"><?php echo __('Add a component'); ?></label>
						<input type="text" id="component_name" name="c_name" style="width: 175px;">
					</div>
					<table cellpadding=0 cellspacing=0 style="display: none; margin-left: 5px; width: 300px;" id="component_add_indicator">
						<tr>
							<td style="width: 20px; padding: 2px;"><?php echo image_tag('spinning_20.gif'); ?></td>
							<td style="padding: 0px; text-align: left;"><?php echo __('Adding component, please wait'); ?>...</td>
						</tr>
					</table>
				</form>
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td style="width: auto; padding-right: 5px; vertical-align: top;">
			<div id="project_editions"<?php if (!$project->isEditionsEnabled()): ?> style="display: none;"<?php endif; ?>>
				<div class="faded_medium" id="no_editions" style="padding: 5px;<?php if (count($project->getEditions()) > 0): ?> display: none;<?php endif; ?>"><?php echo __('There are no editions'); ?></div>
				<table cellpadding=0 cellspacing=0 style="width: 100%; margin-top: 10px;">
					<tbody id="edition_table">
					<?php foreach ($project->getEditions() as $edition): ?>
						<?php include_template('configuration/editionbox', array('theProject' => $project, 'edition' => $edition)); ?>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div style="padding: 2px 5px 5px 5px;<?php if ($project->isEditionsEnabled()): ?> display: none;<?php endif; ?>" class="faded_medium"><?php echo __('This project does not use editions'); ?>.<br><?php echo __('Editions can be enabled in project settings'); ?>.</div>
		</td>
		<td style="width: 375px; padding-right: 5px; vertical-align: top;">
			<div id="project_components"<?php if (!$project->isComponentsEnabled()): ?> style="display: none;"<?php endif; ?>>
				<div class="faded_medium" id="no_components" style="padding: 5px;<?php if (count($project->getComponents()) > 0): ?> display: none;<?php endif; ?>"><?php echo __('There are no components'); ?></div>
				<table cellpadding=0 cellspacing=0 style="width: 100%; margin-top: 10px;">
					<tbody id="component_table">
					<?php foreach ($project->getComponents() as $component): ?>
						<?php include_template('configuration/componentbox', array('component' => $component)); ?>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div style="padding: 2px 5px 5px 5px;<?php if ($project->isComponentsEnabled()): ?> display: none;<?php endif; ?>" class="faded_medium"><?php echo __('This project does not use components'); ?>.<br><?php echo __('Components can be enabled in project settings'); ?>.</div>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="padding-right: 5px; padding-top: 10px;">
			<div class="config_header nobg" style="margin-top: 10px;"><b><?php echo __('Releases'); ?></b></div>
			<?php include_template('configuration/builds', array('parent' => $project, 'access_level' => $access_level)); ?>
			<div style="padding: 2px 5px 5px 5px;<?php if ($project->isBuildsEnabled()): ?> display: none;<?php endif; ?>" class="faded_medium"><?php echo __('This project does not use releases'); ?>.<br><?php echo __('Releases can be enabled in project settings'); ?>.</div>
		</td>
	</tr>
</table>