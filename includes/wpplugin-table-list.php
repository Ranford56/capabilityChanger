<table class="wp-list-table widefat "cellspacing="0">
	<thead>
		<tr>
			<th><?php _e('First Column', 'pippinw'); ?></th>
			<th><?php _e('Second Column', 'pippinw'); ?></th>

		</tr>
	</thead>
	<tfoot>
		<tr>
			<th><?php _e('First Column', 'pippinw'); ?></th>
			<th><?php _e('Second Column', 'pippinw'); ?></th>
 		</tr>
	</tfoot>
	<tbody>
    <tr>
	<?php
	// if( isset($_POST['submit'])){
	// 	db();
	// 	run();
	// }
	$option = get_option('wpplugin_settings');
	$i = 0;
	if( $option == true ) :	

		foreach( $option as $row ) : ?>
			<tr>
				<td><?php echo $option["$i"]['meh1'];?></td>
				<td><?php echo $option["$i"]['meh2']; ?></td>
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