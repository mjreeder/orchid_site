<?php



class Config
{
    public static function database(){

    }
    public static function DBTables(){
        return (object) array(
            "area"               => "area",
            "bloom"              => "bloom",
            "class"              => "class",
            "family"             => "family",
            "genus"              => "genus",
            "health"             => "health",
            "order"              => "order",
            "pest_control"       => "pest_control",
            "photos"             => "photos",
            "phylum"             => "phylum",
            "plants"             => "plants",
            "plant_status"       => "plant_status",
            "potting"            => "potting",
            "species"            => "species",
            "subtribe"           => "subtribe",
            "table"              => "table",
            "tribe"              => "tribe",
            "users"              => "users",
            "variety"            => "variety"
        );
    }

    public static function AWS(){
        return include "AWS.CONFIG.php";

    }

}