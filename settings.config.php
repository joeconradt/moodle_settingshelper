<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Theme settings array
 *
 * @package     theme_
 * @author      Joseph Conradt (joseph.conradt@coursebit.net)
 * @copyright   2014 CourseBit (www.coursebit.net)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

return array(
	'theme_name' => 'theme_testing',
	'pages' => array(
		'general' => array(
			'settings' => array(
				'mainlogo' => array(
					'type'           => 'admin_setting_configstoredfile',
					'visiblename'    => 'settings:mainlogo',
					'description'    => 'settings:mainlogo_desc',
					'filearea'       => 'logo',
				),
				'linkcolor' => array(
					'type'           => 'admin_setting_configcolourpicker',
					'visiblename'    => 'settings:linkcolor',
					'description'    => 'settings:linkcolor_desc',
					'defaultsetting' => 'blue'
				),
				'linkhovercolor' => array(
					'type'           => 'admin_setting_configcolourpicker',
					'visiblename'    => 'settings:linkhovercolor',
					'description'    => 'settings:linkhovercolor_desc',
					'defaultsetting' => 'blue'
				),
				'customcss' => array(
					'type'           => 'admin_setting_configtextarea',
					'visiblename'    => 'settings:customcss',
					'description'    => 'settings:customcss_desc',
					'defaultsetting' => ''
				),
			),
		),
		'social' => array(
			'settings' => array(
				'facebook_link' => array(
					'type'           => 'admin_setting_configtext',
					'visiblename'    => 'settings:facebook_link',
					'description'    => 'settings:facebook_link_desc',
					'defaultsetting' => '',
					'paramtype'      => PARAM_URL,
				),
				'twitter_link' => array(
					'type'           => 'admin_setting_configtext',
					'visiblename'    => 'settings:twitter_link',
					'description'    => 'settings:twitter_link_desc',
					'defaultsetting' => '',
					'paramtype'      => PARAM_URL,
				),
				'linkedin_link' => array(
					'type'           => 'admin_setting_configtext',
					'visiblename'    => 'settings:linkedin_link',
					'description'    => 'settings:linkedin_link_desc',
					'defaultsetting' => '',
					'paramtype'      => PARAM_URL,
				),
				'googleplus_link' => array(
					'type'           => 'admin_setting_configtext',
					'visiblename'    => 'settings:googleplus_link',
					'description'    => 'settings:googleplus_link_desc',
					'defaultsetting' => '',
					'paramtype'      => PARAM_URL,
				),
				'googleplus_link' => array(
					'type'           => 'admin_setting_configtext',
					'visiblename'    => 'settings:googleplus_link',
					'description'    => 'settings:googleplus_link_desc',
					'defaultsetting' => '',
					'paramtype'      => PARAM_URL,
				),
				'youtube_link' => array(
					'type'           => 'admin_setting_configtext',
					'visiblename'    => 'settings:youtube_link',
					'description'    => 'settings:youtube_link_desc',
					'defaultsetting' => '',
					'paramtype'      => PARAM_URL,
				),
				'wordpress_link' => array(
					'type'           => 'admin_setting_configtext',
					'visiblename'    => 'settings:wordpress_link',
					'description'    => 'settings:wordpress_link_desc',
					'defaultsetting' => '',
					'paramtype'      => PARAM_URL,
				),
				'dropbox_link' => array(
					'type'           => 'admin_setting_configtext',
					'visiblename'    => 'settings:dropbox_link',
					'description'    => 'settings:dropbox_link_desc',
					'defaultsetting' => '',
					'paramtype'      => PARAM_URL,
				),
				'skype_link' => array(
					'type'           => 'admin_setting_configtext',
					'visiblename'    => 'settings:skype_link',
					'description'    => 'settings:skype_link_desc',
					'defaultsetting' => '',
					'paramtype'      => PARAM_URL,
				),

			),
		),
	),
);