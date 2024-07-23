<?php

require_once ('Models/Database.php');
require_once ('Models/ChargerData.php');
class ChargersDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /**
     * fetch all the data regarding the EV charge-points within the stored database
     *
     * @return array returns the results of all chargers within the database
     */
    public function fetchTenChargers()
    {
        $sqlQuery = "SELECT chargers.*, users.username, users.fullname, users.photo, users.phoneNumber FROM chargers INNER JOIN users WHERE users.userID = chargers.owner LIMIT 10";
        //echo $sqlQuery;           //commented out, only needed for testing

        //execute SQL Query statement stated above
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        //instantiate $dataSet array and feed the data from said SQL query into it via a ChargerData object
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new ChargerData($row);
        }
        return $dataSet;
    }

    /**
     * display data on sought after EV charge-points
     *
     * @param String $searchData users desired data to be searched for
     * @return array results from the database via queried $searchData
     */
    public function searchChargers($searchData)
    {
        //clear search query of exploits before use
        $search = filter_var($searchData, FILTER_SANITIZE_STRING);

        $searchQuery = "SELECT chargers.*, users.username, users.fullname, users.photo, users.phoneNumber FROM chargers INNER JOIN users ON users.userID = chargers.owner WHERE address1 LIKE ? OR address2 LIKE ? OR postcode LIKE ? LIMIT 15";

        //prepare SQL Query statement stated above
        $statement = $this->_dbHandle->prepare($searchQuery);
        //bind values to the placeholders in the query
        $statement->bindValue(1, '%' . $search . '%');
        $statement->bindValue(2, '%' . $search . '%');
        $statement->bindValue(3, '%' . $search . '%');
        //execute SQL Query with bindings
        $statement->execute();

        //instantiate $dataSet array and feed the data from said SQL query into it via a ChargerData object
        $dataSet = [];
        while ($row = $statement->fetch()) {

            $CPset = new ChargerData($row);
            $serializedData = $CPset->jsonSerialize();
            array_push($dataSet, $serializedData);
        }

        return json_encode($dataSet);
    }
}