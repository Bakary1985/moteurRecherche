<?php

namespace App\Data;

use App\Entity\Category;

class SearchData{

    /**
     * @var string
     */
    public $q ="";

    /**
     * @var Category[]
     */
    public $category = [];

    /**
     *@var null|integer
     */
    public $min;

    /**
     *@var null|integer 
     */
    public $max;

    /**
     *@var boolean 
     */
    public $promo = false;

}