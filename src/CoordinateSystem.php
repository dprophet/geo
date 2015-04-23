<?php

namespace Brick\Geo;

use Brick\Geo\Exception\GeometryException;

/**
 * Represents the dimensionality and spatial reference system of a geometry.
 */
class CoordinateSystem
{
    /**
     * Whether this coordinate system has Z-coordinates.
     *
     * @var boolean
     */
    private $hasZ;

    /**
     * Whether this coordinate system has M-coordinates.
     *
     * @var boolean
     */
    private $hasM;

    /**
     * The Spatial Reference System Identifier of this coordinate system.
     *
     * @var integer
     */
    private $srid;

    /**
     * Private constructor. Use a factory method to obtain an instance.
     *
     * @param boolean $hasZ Whether the coordinate system has Z-coordinates.
     * @param boolean $hasM Whether the coordinate system has M-coordinates.
     * @param integer $srid The Spatial Reference ID of the coordinate system.
     */
    private function __construct($hasZ, $hasM, $srid)
    {
        $this->hasZ = $hasZ;
        $this->hasM = $hasM;
        $this->srid = $srid;
    }

    /**
     * @param boolean $hasZ Whether the coordinate system has Z-coordinates.
     * @param boolean $hasM Whether the coordinate system has M-coordinates.
     * @param integer $srid The Spatial Reference ID of the coordinate system.
     *
     * @return CoordinateSystem
     */
    public static function create($hasZ, $hasM, $srid = 0)
    {
        return new self((bool) $hasZ, (bool) $hasM, (int) $srid);
    }

    /**
     * Returns a CoordinateSystem with X and Y coordinates, and an optional SRID.
     *
     * @param integer $srid The optional Spatial Reference ID.
     *
     * @return CoordinateSystem
     */
    public static function xy($srid = 0)
    {
        return new self(false, false, (int) $srid);
    }

    /**
     * Returns a CoordinateSystem with X, Y and Z coordinates, and an optional SRID.
     *
     * @param integer $srid The optional Spatial Reference ID.
     *
     * @return CoordinateSystem
     */
    public static function xyz($srid = 0)
    {
        return new self(true, false, (int) $srid);
    }

    /**
     * Returns a CoordinateSystem with X, Y and M coordinates, and an optional SRID.
     *
     * @param integer $srid The optional Spatial Reference ID.
     *
     * @return CoordinateSystem
     */
    public static function xym($srid = 0)
    {
        return new self(false, true, (int) $srid);
    }


    /**
     * Returns a CoordinateSystem with X, Y, Z and M coordinates, and an optional SRID.
     *
     * @param integer $srid The optional Spatial Reference ID.
     *
     * @return CoordinateSystem
     */
    public static function xyzm($srid = 0)
    {
        return new self(true, true, (int) $srid);
    }

    /**
     * Returns whether this coordinate system has Z-coordinates.
     *
     * @return boolean
     */
    public function hasZ()
    {
        return $this->hasZ;
    }

    /**
     * Returns whether this coordinate system has M-coordinates.
     *
     * @return boolean
     */
    public function hasM()
    {
        return $this->hasM;
    }

    /**
     * Returns the Spatial Reference System Identifier of this coordinate system.
     *
     * @return integer
     */
    public function SRID()
    {
        return $this->srid;
    }

    /**
     * Returns the coordinate dimension of this coordinate system.
     *
     * @return integer 2 for (X,Y), 3 for (X,Y,Z) and (X,Y,M), 4 for (X,Y,Z,M).
     *
     * @throws GeometryException
     */
    public function coordinateDimension()
    {
        $coordinateDimension = 2;

        if ($this->hasZ) {
            $coordinateDimension++;
        }

        if ($this->hasM) {
            $coordinateDimension++;
        }

        return $coordinateDimension;
    }

    /**
     * Returns the spatial dimension of this coordinate system.
     *
     * @return integer 2 for (X,Y) and (X,Y,M), 3 for (X,Y,Z) and (X,Y,Z,M).
     */
    public function spatialDimension()
    {
        return $this->hasZ ? 3 : 2;
    }
}