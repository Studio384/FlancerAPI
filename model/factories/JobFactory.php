<?php

namespace model\factories;

use model\Job;

abstract class JobFactory {
    public static function CreateFromArray( $array ) {
        if ( !array_key_exists( 'id', $array ) ) {
            $array['id'] = null;
        }
        
        return new Job(
            $array['title'],
            $array['company'],
            $array['phone'],
            $array['email'],
            $array['start_date'],
            $array['end_date'],
            $array['minimum_bid'],
            $array['description'],
            $array['street'],
            $array['number'],
            $array['city'],
            $array['zip'],
            $array['country'],
            $array['id']
        );
    }
}