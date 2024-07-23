<?php

class ChargerData implements JsonSerializable
{
    protected $_id, $_address1, $_address2, $_postcode, $_lat, $_lng, $_cost, $_owner, $_ownerUsername, $_ownerFullname, $_ownerPhoto, $_ownerPhoneNumber;

    public function __construct($dbRow) {
        $this->_id = $dbRow['chargerID'];
        $this->_address1 = $dbRow['address1'];
        $this->_address2 = $dbRow['address2'];
        $this->_postcode = $dbRow['postcode'];
        $this->_lat = $dbRow['lat'];
        $this->_lng = $dbRow['lng'];
        $this->_cost = $dbRow['cost'];
        $this->_owner = $dbRow['owner'];
        $this->_ownerUsername = $dbRow['username'];
        $this->_ownerFullname = $dbRow['fullname'];
        $this->_ownerPhoto = $dbRow['photo'];
        $this->_ownerPhoneNumber = $dbRow['phoneNumber'];
    }

    // Class accessors found below
    public function getChargerID() {
        return $this->_id;
    }
    public function getAddress1() {
        return $this->_address1;
    }
    public function getAddress2() {
        return $this->_address2;
    }
    public function getPostcode() {
        return $this->_postcode;
    }
    public function getLat() {
        return $this->_lat;
    }
    public function getLng() {
        return $this->_lng;
    }
    public function getCost() {
        return $this->_cost;
    }
    public function getOwner() {
        return $this->_owner;
    }
    public function getOwnerUsername() {
        return $this->_ownerUsername;
    }
    public function getOwnerFullname() {
        return $this->_ownerFullname;
    }
    public function getOwnerPhoto() {
        return $this->_ownerPhoto;
    }
    public function getOwnerPhoneNumber() {
        return $this->_ownerPhoneNumber;
    }


    // Class mutators found below
    public function setAddress1($address1) {
        $this->_address1 = $address1;
    }
    public function setAddress2($address2) {
        $this->_address2 = $address2;
    }
    public function setPostcode($postcode) {
        $this->_postcode = $postcode;
    }
    public function setLat($lat) {
        $this->_lat = $lat;
    }
    public function setLng($lng) {
        $this->_lng = $lng;
    }
    public function setCost($cost) {
        $this->_cost = $cost;
    }
    public function setOwner($owner) {
        $this->_owner = $owner;
    }
    public function setOwnerUsername($ownerUsername) {
        $this->_ownerUsername = $ownerUsername;
    }
    public function setOwnerFullname($ownerFullname) {
        $this->_ownerFullname = $ownerFullname;
    }
    public function setOwnerPhoto($ownerPhoto) {
        $this->_ownerPhoto = $ownerPhoto;
    }
    public function setOwnerPhoneNumber($ownerPhoneNumber) {
        $this->_ownerPhoneNumber = $ownerPhoneNumber;
    }


    // Overriding of the method from the JsonSerializable Class
    /*
     * Method to create a JSON dataset from the internal class fields
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'chargerID' => $this->_id,
            'address1' => $this->_address1,
            'address2' => $this->_address2,
            'postcode' => $this->_postcode,
            'lat' => $this->_lat,
            'lng' => $this->_lng,
            'cost' => $this->_cost,
            'ownerUsername' => $this->_ownerUsername,
            'ownerFullname' => $this->_ownerFullname,
            'ownerPhoto' => $this->_ownerPhoto,
            'ownerPhoneNumber' => $this->_ownerPhoneNumber
        ];
    }
}