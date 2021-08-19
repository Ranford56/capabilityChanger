<?php

function wpplugin_settings_page_markup()
{
  // Double check user capabilities
  if ( !current_user_can('manage_options') ) {
      return;
  }
  include( WPPLUGIN_DIR . 'templates/admin/settings-page.php');

}

function wpplugin_settings_pages()
{
  add_menu_page(
    'Role Timer',
    'Role Timer',
    'manage_options',
    'wpplugin',
    'wpplugin_settings_page_markup',
    'dashicons-screenoptions',
    100
  );

  add_submenu_page(
    'wpplugin',
    'Delete Options',
    'Delete Options',
    'manage_options',
    'wpplugin_delete_page',
    'wpplugin_settings_subpage_markup'
  );
}
add_action( 'admin_menu', 'wpplugin_settings_pages' );

function wpplugin_settings_subpage_markup(){

  if ( !current_user_can('manage_options') ) {
    return;
  }

  ?>
  <h1><?php esc_html_e( get_admin_page_title() ); ?></h1>


<table class="wp-list-table widefat stripped "cellspacing="0">
	<thead>
		<tr>
      <th><?php _e('ID', 'pippinw'); ?></th>
			<th><?php _e('Role From', 'pippinw'); ?></th>
			<th><?php _e('Role To', 'pippinw'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
      <th><?php _e('ID', 'pippinw'); ?></th>
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
        <td><?php echo $row;?></td>
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
  $options = get_option( 'wpplugin_settings' );
  $options =array_keys($options);

  $html = "<div class='wrap'><form method='POST'><select id='wpplugin_settings_options' name='wpplugin_settings_select_delete'>";

  foreach ( $options as $option ){
    $html .= "<option value='$option'> " . $option . "</option>";
  }

  $html .= "<input type='submit' name='delete' id='delete' class='button button-primary' value='Delete' onClick='window.location.href=window.location.href'></select></form></div>";

  echo $html;



  if( isset($_POST['delete'])){
    $i = $_POST['wpplugin_settings_select_delete'];
    $array = get_option("wpplugin_settings");
    unset($array["$i"]);
    update_option("wpplugin_settings", $array);
  }

}

// Add a link to your settings page in your plugin
function wpplugin_add_settings_link( $links ) {
    $settings_link = '<a href="admin.php?page=wpplugin">' . __( 'Settings' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}
$filter_name = "plugin_action_links_" . plugin_basename( __FILE__ );
add_filter( $filter_name, 'wpplugin_add_settings_link' );



function myprefix_custom_cron_schedule( $schedules ) {
  $schedules['every_minute'] = array(
      'interval' => 900, // Every minute
      'display'  => __( 'Every 15 minutes' ),
  );
  return $schedules;
}
add_filter( 'cron_schedules', 'myprefix_custom_cron_schedule' );

//Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'myprefix_cron_hook' ) ) {
  wp_schedule_event( time(), 'every_minute', 'myprefix_cron_hook' );
}

///Hook into that action that'll fire every six hours
add_action( 'myprefix_cron_hook', 'run' );


function run(){
  $option = get_option('wpplugin_settings');
  change_role( $option );
}

//create your function, that runs on cron
function change_role( $array ){
  global $wpdb;
  foreach (array_keys($array) as $i){
    $from = $array["$i"]['meh1'];
    $to = $array["$i"]['meh2'];
    $args = array(
      'role'        => $from
    );
    $users = get_users( $args );
    foreach ( $users as $user ){
      $user_id = $user->ID;
      $logtime = get_user_meta($user_id, 'last_login', true);
      $date = new DateTime($logtime);
      $date->modify('+5 day');
      var_dump($date);
      $today = new DateTime('now', new DateTimeZone('America/Guayaquil'));
      if( $today->format('Y-m-d H:i:s') >= $date->format('Y-m-d H:i:s') ){
        $new_value = array( "$to" => 1 );
        update_user_meta( $user_id, $wpdb->prefix.'capabilities', $new_value );
      }
    }
}
}

function user_last_login( $user ) {
  $now = time();
  date_default_timezone_set('America/Guayaquil');
  $date = date('Y-m-d H:i:s', $now);
  update_user_meta( $user->ID, 'last_login', $date);
}
add_action( 'wp_login', 'user_last_login', 10, 2 );