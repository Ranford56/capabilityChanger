<?php


class settingsFields{

	public function capabilitiesSettings()
	{
		add_settings_section(
				'capabilitiesSettingsSection',
				'Settings',
				'capabilitiesSectionCallback',
				'capabilitiesPlugin'
		);

		add_settings_field(
				'capabilitiesSettingsCheckbox',
				'From',
				'capabilitiesCheckboxCallback',
				'capabilitiesPlugin',
				'capabilitiesSettingsSection'
		);

		add_settings_field(
				'capabilitiesSettingsSelect',
				'To',
				'capabilitiesSelectCallback',
				'capabilitiesPlugin',
				'capabilitiesSettingsSection'
		);

		register_setting(
				'capabilitiesPlugin',
				'capabilitiesSettingsSection'
		);

		add_action( 'admin_init', array($this, 'capabilitiesSettings') );

		}



		public function capabilitiesSectionCallback() {
			esc_html_e( 'Select the role you want to change to and from, please be careful selecting roles like administrator');
		}

		public function capabilitiesCheckboxCallback() {
			$options = get_option( 'capabilitiesSettings' );
			$select = '';
			if( isset( $options[ 'select_from' ] ) ) {
				$select = esc_html($options['select_from']);
			}
			$roleNames = new WP_Roles;
			$roles = $roleNames->get_names();
			$arrRoles = array_keys($roles);
			$html = "<select id='capabilitiesSettingsOptions' name='capabilitiesSettingsSelectFrom'>";
			foreach ( $arrRoles as $rol ){
				$html .= "<option value='$rol'" . selected( $select, $rol, false) . ">" . $rol . "</option>";
			}
			$html .= '</select>';
			echo $html;
		}
}