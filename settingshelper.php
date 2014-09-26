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
 * Settings helper for loading settings from array
 *
 * @package     theme
 * @author      Joseph Conradt (joseph.conradt@coursebit.net)
 * @copyright   2014 CourseBit (www.coursebit.net)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class settings_helper {

	private $themename;
	private $ADMIN;

	/**
	 * Constructor
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param admin_settingpage $settingpage
	 */
	public function __construct($ADMIN) {
		$this->ADMIN = $ADMIN;
	}

	/**
	 * Prepare the settings page by parsing a settings_config array
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param array $settings_config
	 */
	public function prepare_settings($settings_config) {

		if(!is_array($settings_config)) {
			throw new Exception('Settings must be an array.');
		}

		$this->verify_value($settings_config, 'theme_name');
		$this->themename = $settings_config['theme_name'];

		$this->ADMIN->add('themes', new admin_category($this->themename, get_string('pluginname', $this->themename)));

		foreach($settings_config['pages'] as $pagename => $page_array) {

			$settingpagetitle = get_string(sprintf('settings:page:%s', $pagename), $this->themename);
			$settingpagename  = sprintf('%s_%s', $this->themename, $pagename);
			$settingpage = new admin_settingpage($settingpagename, $settingpagetitle);

			foreach($page_array['settings'] as $key => $settings_array) {

				$setting = null;
				
				$this->verify_value($settings_array, 'type');
				$this->verify_value($settings_array, 'visiblename');
				$this->verify_value($settings_array, 'description');

				$setting_type = $settings_array['type'];
				$setting_type_call = sprintf('get_%s', $setting_type);

				// each setting class should have its own method to return a configured setting object
				if(is_callable(array($this, $setting_type_call))) {

					$setting = $this->$setting_type_call($key, $settings_array);
				} else {
					throw new Exception('Method not found for setting type: ' . $setting_type);
				}

				$setting->set_updatedcallback('theme_reset_all_caches');
				$settingpage->add($setting);

			}

			$this->ADMIN->add($this->themename, $settingpage);
		}

	}

	/**
	 * Get new admin_setting_configtext
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param string $name
	 * @param array $options
	 * @return admin_setting_configtext
	 */
	public function get_admin_setting_configtext($name, $options) {

		$name = sprintf('%s%s', $this->themename, $name);

		$this->verify_value($options, 'defaultsetting');

		$paramtype = isset($options['paramtype']) ? $options['paramtype'] : PARAM_RAW;
		$size      = isset($options['size']) ? $options['size'] : null;

		$setting = new admin_setting_configtext(
			$name,
			get_string($options['visiblename'], $this->themename),
			get_string($options['description'], $this->themename),
			$options['defaultsetting'],
			$paramtype,
			$size
		);

		return $setting;
	}

	/**
	 * Get new admin_setting_configtextarea
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param string $name
	 * @param array $options
	 * @return admin_setting_configtextarea
	 */
	public function get_admin_setting_configtextarea($name, $options) {

		$name = sprintf('%s%s', $this->themename, $name);

		$this->verify_value($options, 'defaultsetting');

		$paramtype = isset($options['paramtype']) ? $options['paramtype'] : PARAM_RAW;
		$cols      = isset($options['cols']) ? $options['cols'] : '60';
		$rows      = isset($options['rows']) ? $options['rows'] : '8';

		$setting = new admin_setting_configtextarea(
			$name,
			get_string($options['visiblename'], $this->themename),
			get_string($options['description'], $this->themename),
			$options['defaultsetting'],
			$paramtype,
			$cols,
			$rows
		);

		return $setting;
	}

	/**
	 * Get new admin_setting_confightmleditor
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param string $name
	 * @param array $options
	 * @return admin_setting_confightmleditor
	 */
	public function get_admin_setting_confightmleditor($name, $options) {

		$name = sprintf('%s%s', $this->themename, $name);

		$this->verify_value($options, 'defaultsetting');

		$paramtype = isset($options['paramtype']) ? $options['paramtype'] : PARAM_RAW;
		$cols      = isset($options['cols']) ? $options['cols'] : '60';
		$rows      = isset($options['rows']) ? $options['rows'] : '8';

		$setting = new admin_setting_confightmleditor(
			$name,
			get_string($options['visiblename'], $this->themename),
			get_string($options['description'], $this->themename),
			$options['defaultsetting'],
			$paramtype,
			$cols,
			$rows
		);

		return $setting;
	}

	/**
	 * Get new admin_setting_configpasswordunmask
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param string $name
	 * @param array $options
	 * @return admin_setting_configpasswordunmask
	 */
	public function get_admin_setting_configpasswordunmask($name, $options) {

		$name = sprintf('%s%s', $this->themename, $name);

		$this->verify_value($options, 'defaultsetting');

		$setting = new admin_setting_configpasswordunmask(
			$name,
			get_string($options['visiblename'], $this->themename),
			get_string($options['description'], $this->themename),
			$options['defaultsetting']
		);

		return $setting;
	}

	/**
	 * Get new admin_setting_configempty
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param string $name
	 * @param array $options
	 * @return admin_setting_configempty
	 */
	public function get_admin_setting_configempty($name, $options) {

		$name = sprintf('%s%s', $this->themename, $name);

		$setting = new admin_setting_configempty(
			$name,
			get_string($options['visiblename'], $this->themename),
			get_string($options['description'], $this->themename)
		);

		return $setting;
	}

	/**
	 * Get new admin_setting_configfile
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param string $name
	 * @param array $options
	 * @return admin_setting_configfile
	 */
	public function get_admin_setting_configfile($name, $options) {

		$name = sprintf('%s%s', $this->themename, $name);

		$this->verify_value($options, 'defaultdirectory');

		$setting = new admin_setting_configfile(
			$name,
			get_string($options['visiblename'], $this->themename),
			get_string($options['description'], $this->themename),
			$options['defaultdirectory']
		);

		return $setting;
	}

	/**
	 * Get new admin_setting_configexecutable
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param string $name
	 * @param array $options
	 * @return admin_setting_configexecutable
	 */
	public function get_admin_setting_configexecutable($name, $options) {

		return $this->get_admin_setting_configfile($name, $options);
	}

	/**
	 * Get new admin_setting_configdirectory
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param string $name
	 * @param array $options
	 * @return admin_setting_configdirectory
	 */
	public function get_admin_setting_configdirectory($name, $options) {

		return $this->get_admin_setting_configfile($name, $options);
	}

	/**
	 * Get new admin_setting_configcheckbox
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param string $name
	 * @param array $options
	 * @return admin_setting_configcheckbox
	 */
	public function get_admin_setting_configcheckbox($name, $options) {

		$name = sprintf('%s%s', $this->themename, $name);

		$this->verify_value($options, 'defaultsetting');

		$yes      = isset($options['yes']) ? $options['yes'] : '1';
		$no       = isset($options['no']) ? $options['no'] : '0';

		$setting = new admin_setting_configcheckbox(
			$name,
			get_string($options['visiblename'], $this->themename),
			get_string($options['description'], $this->themename),
			$options['defaultsetting'],
			$yes,
			$no
		);

		return $setting;
	}

	/**
	 * Get new admin_setting_configmulticheckbox
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param string $name
	 * @param array $options
	 * @return admin_setting_configmulticheckbox
	 */
	public function get_admin_setting_configmulticheckbox($name, $options) {

		$name = sprintf('%s%s', $this->themename, $name);

		$this->verify_value($options, 'defaultsetting');
		$this->verify_value($options, 'choices');

		$setting = new admin_setting_configmulticheckbox(
			$name,
			get_string($options['visiblename'], $this->themename),
			get_string($options['description'], $this->themename),
			$options['defaultsetting'],
			$options['choices']
		);

		return $setting;
	}

	/**
	 * Get new admin_setting_configmulticheckbox2
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param string $name
	 * @param array $options
	 * @return admin_setting_configmulticheckbox2
	 */
	public function get_admin_setting_configmulticheckbox2($name, $options) {

		return $this->get_admin_setting_configmulticheckbox($name, $options);
	}

	/**
	 * Get new admin_setting_configselect
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param string $name
	 * @param array $options
	 * @return admin_setting_configselect
	 */
	public function get_admin_setting_configselect($name, $options) {

		$name = sprintf('%s%s', $this->themename, $name);

		$this->verify_value($options, 'defaultsetting');
		$this->verify_value($options, 'choices');

		$setting = new admin_setting_configselect(
			$name,
			get_string($options['visiblename'], $this->themename),
			get_string($options['description'], $this->themename),
			$options['defaultsetting'],
			$options['choices']
		);

		return $setting;
	}

	/**
	 * Get new admin_setting_configtime
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param string $name
	 * @param array $options
	 * @return admin_setting_configtime
	 */
	public function get_admin_setting_configtime($name, $options) {

		$name = sprintf('%s%s', $this->themename, $name);

		$this->verify_value($options, 'defaultsetting');
		$this->verify_value($options, 'minutesname');

		$setting = new admin_setting_configtime(
			$name,
			get_string($options['minutesname'], $this->themename),
			get_string($options['visiblename'], $this->themename),
			get_string($options['description'], $this->themename),
			$options['defaultsetting']
		);

		return $setting;
	}

	/**
	 * Get new admin_setting_configduration
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param string $name
	 * @param array $options
	 * @return admin_setting_configduration
	 */
	public function get_admin_setting_configduration($name, $options) {

		$name = sprintf('%s%s', $this->themename, $name);

		$this->verify_value($options, 'defaultsetting');

		$defaultunit = isset($options['defaultunit']) ? $options['defaultunit'] : 86400;

		$setting = new admin_setting_configduration(
			$name,
			get_string($options['visiblename'], $this->themename),
			get_string($options['description'], $this->themename),
			$options['defaultsetting'],
			$defaultunit
		);

		return $setting;
	}

	/**
	 * Get new admin_setting_configiplist
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param string $name
	 * @param array $options
	 * @return admin_setting_configiplist
	 */
	public function get_admin_setting_configiplist($name, $options) {

		return $this->get_admin_setting_configtextarea($name, $options);
	}

	/**
	 * Get new admin_setting_users_with_capability
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param string $name
	 * @param array $options
	 * @return admin_setting_users_with_capability
	 */
	public function get_admin_setting_users_with_capability($name, $options) {

		$name = sprintf('%s%s', $this->themename, $name);

		$this->verify_value($options, 'defaultsetting');
		$this->verify_value($options, 'capabilitiy');

		$includeadmins = isset($options['includeadmins']) ? $options['includeadmins'] : true;

		$setting = new admin_setting_users_with_capability(
			$name,
			get_string($options['visiblename'], $this->themename),
			get_string($options['description'], $this->themename),
			$options['defaultsetting'],
			$options['capabilitiy'],
			$includeadmins
		);

		return $setting;
	}

	/**
	 * Get new admin_setting_configstoredfile
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param string $name
	 * @param array $options
	 * @return admin_setting_configstoredfile
	 */
	public function get_admin_setting_configstoredfile($name, $options) {

		$name = sprintf('%s%s', $this->themename, $name);

		$this->verify_value($options, 'filearea');

		$itemid        = isset($options['itemid']) ? $options['itemid'] : 0;
		$options_param = isset($options['options']) ? $options['options'] : null;

		$setting = new admin_setting_configstoredfile(
			$name,
			get_string($options['visiblename'], $this->themename),
			get_string($options['description'], $this->themename),
			$options['filearea'],
			$itemid,
			$options_param
		);

		return $setting;
	}

	/**
	 * Get new admin_setting_configcolourpicker
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param string $name
	 * @param array $options
	 * @return admin_setting_configcolourpicker
	 */
	public function get_admin_setting_configcolourpicker($name, $options) {

		$name = sprintf('%s%s', $this->themename, $name);

		$this->verify_value($options, 'defaultsetting');

		$previewconfig = isset($options['previewconfig']) ? $options['previewconfig'] : null;

		$setting = new admin_setting_configcolourpicker(
			$name,
			get_string($options['visiblename'], $this->themename),
			get_string($options['description'], $this->themename),
			$options['defaultsetting'],
			$previewconfig
		);

		return $setting;
	}

	/**
	 * Verify a value exists within an array by key
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param array $array
	 * @param string $key
	 * @return bool
	 */
	public function verify_value($array, $key) {
		if(isset($array[$key])) {
			return true;
		} else {
			throw new Exception(sprintf('Setting [%s] must be present in array', $key));
		}
	}

	/**
	 * Helper method to return a value if true, or a default if false
	 *
	 * @author Joseph Conradt (joseph.conradt@coursebit.net)
	 * @param mixed $value
	 * @param mixed $default
	 * @return mixed
	 */
	public function get_value($value, $default) {
		if(isset($value)) {
			return $value;
		} else {
			return $default;
		}
	}
}