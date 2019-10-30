<?php

namespace Sonnenglas\AmazonMws\DataType;

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
   * @param float $height
   * @param string $unit
   */
  public function setDimensions( float $height, string $unit )
  {
    /**
     * Check unit value is valid.
     */
    if ( ! in_array( $unit, Enum::DIMENSIONS_UNITS ) )
    {
      throw new \InvalidArgumentException( 'Invalid dimension unit. possible: ' . implode( ',', Enum::DIMENSIONS_UNITS ) );
    }

    if ( ( $unit == Enum::DIMENSIONS_UNIT_INCH and $height > 60 ) or ( $unit == Enum::DIMENSIONS_UNIT_CM and $height > 152.4 ) )
    {
      throw new \InvalidArgumentException( 'The height must be less than or equal to 60 inches.' );
    }

    $this->options['Dimensions.Length'] = 40;
    $this->options['Dimensions.Width']  = 48;
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