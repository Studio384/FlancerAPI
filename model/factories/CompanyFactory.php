<?php

namespace model\factories;

use model\Company;

abstract class CompanyFactory {
    public static function CreateFromArray( $array ) {
        if ( !array_key_exists( 'id', $array ) ) {
            $array['id'] = null;
        }
        
        return new Company(
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