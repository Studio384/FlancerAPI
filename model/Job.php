<?php

namespace model;

class Job implements \JsonSerializable {
    function __construct( $title, $company_id, $minimum_bid, $description, $street, $number, $city, $zip, $country, $id = null ) {
        if ($id !== null) {
            $this->setId( $id );
        }
        
        $this->setTitle( $title );
        $this->setCompanyId( $company_id );
        $this->setMinimumBid( $minimum_bid );
        $this->setDescription( $description );
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

    public function setTitle( $title ) {
        $this->title = $title;
    }
    
    public function setCompanyId( $company_id ) {
        $this->company_id = $company_id;
    }
    
    public function setMinimumBid( $minimum_bid ) {
        $this->minimum_bid = $minimum_bid;
    }
    
    public function setDescription( $description ) {
        $this->description = $description;
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
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getCompanyId() {
        return $this->company_id;
    }
    
    public function getMinimumBid() {
        return $this->minimum_bid;
    }
    
    public function getDescription() {
        return $this->description;
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
            'title' => $this->getTitle(),
            'company_id' => $this->getCompanyId(),
            'minimum_bid' => $this->getMinimumBid(),
            'description' => $this->getDescription(),
            'street' => $this->getStreet(),
            'number' => $this->getNumber(),
            'city' => $this->getCity(),
            'zip' => $this->getZip(),
            'country' => $this->getCountry()
        ];
    }
}