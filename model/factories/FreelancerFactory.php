<?php

namespace model\factories;

use model\Freelancer;

abstract class FreelancerFactory {
    public static function CreateFromArray( $array ) {
        if ( !array_key_exists( 'id', $array ) ) {
            $array['id'] = null;
        }
        
        return new Freelancer(
            $array['name'],
            $array['street'],
            $array['number'],
            $array['city'],
            $array['zip'],
            $array['country'],
            $array['id']
        );
    }
}