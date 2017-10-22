<?php

namespace model;

class Freelancer implements \JsonSerializable {
    private $id;
    private $name;
    private $street;
    private $number;
    private $city;
    private $zip;
    private $country;

    function __construct( $name, $street, $number, $city, $zip, $country, $id = null ) {
        $this->setId( $id );
        $this->setName( $name );
        $this->setStreet( $street );
        $this->setNumber( $number );
        $this->setCity( $city );
        $this->setZip( $zip );
        $this->setCountry( $country );
    }

    // Setters
    public function setId( $id ) {
        $this->id = $id;
    }

    public function setName( $name ) {
        $this->name = $name;
    }
    
    public function setStreet( $street ) {
        $this->street = $street;
    }
    
    public function setNumber( $number ) {
        $this->number = $number;
    }
    
    public function setCity( $city ) {
        $this->city = $city;
    }
    
    public function setZip( $zip ) {
        $this->zip = $zip;
    }
    
    public function setCountry( $country ) {
        $this->country = $country;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
		return $this->name;
    }
    
    public function getStreet() {
        return $this->street;
    }
    
    public function getNumber() {
        return $this->number;
    }
    
    public function getCity() {
        return $this->city;
    }
    
    public function getZip() {
        return $this->zip;
    }
    
    public function getCountry() {
        return $this->country;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'street' => $this->getStreet(),
            'number' => $this->getNumber(),
            'city' => $this->getCity(),
            'zip' => $this->getZip(),
            'country' => $this->getCountry()
        ];
    }
}