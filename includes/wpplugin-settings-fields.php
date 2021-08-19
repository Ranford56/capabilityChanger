<?php

function wpplugin_settings() {

  // If plugin settings don't exist, then create them
  if( false == get_option( 'wpplugin_settings' ) ) {
      add_option( 'wpplugin_settings' );
      $db = get_option( 'wpplugin_settings');
      $db = [];
      update_option('wpplugin_settings', $db );
  }

  // Define (at least) one section for our fields
  add_settings_section(
    // Unique identifier for the section
    'wpplugin_settings_section',
    // Section Title
    'Options',
    // Callback for an optional description
    'wpplugin_settings_section_callback',
    // Admin page to add section to
    'wpplugin'
  );

  // Checkbox Field
  add_settings_field(
    'wpplugin_settings_checkbox',
    'From',
    'wpplugin_settings_checkbox_callback',
    'wpplugin',
    'wpplugin_settings_section'
  );


  // Dropdown
  add_settings_field(
    'wpplugin_settings_select',
    'To',
    'wpplugin_settings_select_callback',
    'wpplugin',
    'wpplugin_settings_section'
  );

   add_settings_field(
     'wpplugin_settings_table',
     'Table',
     'wpplugin_settings_table_callback',
     'wpplugin',
     'wpplugin_settings_section'
   );

  register_setting(
    'wpplugin_settings',
    'wpplugin_settings'
  );

}
add_action( 'admin_init', 'wpplugin_settings' );

function wpplugin_settings_delete_callback() {
  

}

function wpplugin_settings_section_callback() {

  esc_html_e( 'Select the role you want to change to and from, be careful selecting roles like administrator');

}


function wpplugin_settings_checkbox_callback( $args ) {

  $options = get_option( 'wpplugin_settings' );

  $select = '';
	if( isset( $options[ 'select_from' ] ) ) {
    $select = esc_html( $options['select_from'] );
  }

  $html = "<select id='wpplugin_settings_options' name='wpplugin_settings_select_from'>";

  $rolenames = new WP_Roles;
  $rolen = $rolenames->get_names();
  $rolitos = array_keys($rolen);

  foreach ( $rolitos as $rol ){
    $html .= "<option value='$rol'" . selected( $select, $rol , false) . ">" . $rol . "</option>";
  }

	$html .= '</select>';

	echo $html;

}


function wpplugin_settings_select_callback( $args ) {

  $options = get_option( 'wpplugin_settings' );

  $select = '';
	if( isset( $options[ 'select_to' ] ) ) {
    $select = esc_html( $options['select_to'] );
	}


  $html = "<select id='wpplugin_settings_options' name='wpplugin_settings_select_to'>";

  $rolenames = new WP_Roles;
  $rolen = $rolenames->get_names();
  $rolitos = array_keys($rolen);

  foreach ( $rolitos as $rol ){
    $html .= "<option value='$rol'" . selected( $select, $rol , false) . ">" . $rol . "</option>";
  }

	$html .= '</select>';

	echo $html;

}


function wpplugin_settings_table_callback(){

?>
<table style="white-space:nowrap;width:100%;" class="wp-list-table widefat stripped "cellspacing="0">
	<thead>
		<tr>
			<th><?php _e('Role From', 'pippinw'); ?></th>
			<th><?php _e('Role To', 'pippinw'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
      <th><?php _e('Role From', 'pippinw'); ?></th>
			<th><?php _e('Role To', 'pippinw'); ?></th>
 		</tr>
	</tfoot>
	<tbody>
    <tr>
	<?php
  function db(){
    $in = [];
    $input = [];
    $input['meh1'] = $_POST['wpplugin_settings_select_from'];
    $input['meh2'] = $_POST['wpplugin_settings_select_to'];
    $in[] = $input;
    $iption = get_option('wpplugin_settings');
    array_push($iption, $input );
    update_option('wpplugin_settings', $iption);
  }

	if( isset($_POST['submit'])){
		db();
		run();
	}
	$option = get_option('wpplugin_settings');
	$i = 0;
	if( $option == true ) :	

		foreach( array_keys($option) as $row ) : ?>
			<tr>
				<td><?php echo $option["$row"]['meh1'];?></td>
				<td><?php echo $option["$row"]['meh2']; ?></td>
			</tr>
			
			<?php $i++;
		endforeach;
	else : 	$option = get_option('wpplugin_settings');
	?>
		<tr>
			<td colspan="3"><?php _e('No data found', 'pippinw'); ?></td>
		</tr>
		<?php 
	endif; 

	?>	
    </tr>
	</tbody>
</table>

<?php
    
}

