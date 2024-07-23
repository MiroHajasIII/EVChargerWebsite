<?php

class UserData
{
    protected $_id, $_username, $_fullname, $_password, $_photo, $_phoneNumber;

    public function __construct($dbRow) {
        $this->_id = $dbRow['userID'];
        $this->_username = $dbRow['username'];
        $this->_fullname = $dbRow['fullname'];
        $this->_password = $dbRow['password'];
        $this->_photo = $dbRow['photo'];
        $this->_phoneNumber = $dbRow['phoneNumber'];
    }

    public function getUserID() {
        return $this->_id;
    }

    public function getUsername() {
        return $this->_username;
    }

    public function getFullname() {
        return $this->_fullname;
    }

    public function getPassword() {
        return $this->_password;
    }

    public function getPhoto() {
        return $this->_photo;
    }

    public function getPhoneNumber() {
        return $this->_phoneNumber;
    }
}