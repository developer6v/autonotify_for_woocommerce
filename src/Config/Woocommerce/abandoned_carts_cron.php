<?php

add_filter( 'cron_schedules', 'twenty_min_personalized' );

function twenty_min_personalized( $schedules ) {
    $schedules['every_20_minutes'] = array(
        'interval' => 1 * MINUTE_IN_SECONDS, 
        'display'  => __( 'A cada 20 minutos' )
    );
    return $schedules;
}


if ( wp_next_scheduled( 'check_abandoned_carts' ) ) {
    wp_schedule_event( time(), 'every_20_minutes', 'check_abandoned_carts' );
}

?>