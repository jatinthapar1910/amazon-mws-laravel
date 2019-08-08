<?php

namespace Sonnenglas\AmazonMws\Datatypes;

use Sonnenglas\AmazonMws\Enum;

class Pallet
{
  private $options = [];
  /**
   * Required attributes, the default is not set yet.
   *
   * @var array
   */
  private $requiredFields = [
    'Dimensions' => false,
    'IsStacked'  => false,
  ];

  /**
   * Set Dimensions
   *
   * @param float $length
   * @param float $width
   * @param float $height
   * @param string $unit
   */
  public function setDimensions( float $length, float $width, float $height, string $unit )
  {
    /**
     * Check unit value is valid.
     */
    if ( ! in_array( $unit, Enum::DIMENSIONS_UNITS ) )
    {
      throw new \InvalidArgumentException( 'Invalid dimension unit. possible: ' . implode( ',', Enum::DIMENSIONS_UNITS ) );
    }

    $this->options['Dimensions.Length'] = $length;
    $this->options['Dimensions.Width']  = $width;
    $this->options['Dimensions.Height'] = $height;
    $this->options['Dimensions.Unit']   = $unit;

    $this->requiredFields['Dimensions'] = true;
  }

  /**
   * Set Weight
   *
   * @param int $value
   * @param string $unit
   */
  public function setWeight( int $value, string $unit )
  {
    /**
     * Check unit value is valid.
     */
    if ( ! in_array( $unit, Enum::WEIGHT_UNITS ) )
    {
      throw new \InvalidArgumentException( 'Invalid weight unit. possible: ' . implode( ',', Enum::WEIGHT_UNITS ) );
    }

    $this->options['Weight.Value'] = $value;
    $this->options['Weight.Unit']  = $unit;
  }

  /**
   * Set IsStacked
   *
   * @param bool $isStacked
   */
  public function setIsStacked( bool $isStacked )
  {
    $this->options['IsStacked'] = $isStacked;

    $this->requiredFields['IsStacked'] = true;
  }

  /**
   * Set PalletNumber
   *
   * @param string $palletNumber
   */
  public function setPalletNumber( string $palletNumber )
  {
    $this->options['PalletNumber'] = $palletNumber;
  }

  /**
   * Check required attributes and return options.
   *
   * @return array
   */
  public function toArray()
  {
    if ( array_sum( $this->requiredFields ) < count( $this->requiredFields ) )
    {
      throw new \InvalidArgumentException( 'Pallet missing required attributes' );
    }

    return $this->options;
  }
}