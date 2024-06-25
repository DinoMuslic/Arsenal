<?php 

require_once __DIR__ . '/../dao/CityDao.class.php';

class CityService {
    private $city_dao;

    public function __construct() {
        $this->city_dao = new CityDao();
    }

    public function add_city($city) {
        return $this->city_dao->add_city($city);
    }

    public function get_all_cities() {
        return $this->city_dao->get_all_cities();
    }
}