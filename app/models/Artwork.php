<?php
// app/models/Artwork.php

class Artwork extends Eloquent
{
    public $timestamp = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'artworks';

    protected $guarded = [];

}