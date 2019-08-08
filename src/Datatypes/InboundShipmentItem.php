<?php

namespace Sonnenglas\AmazonMws\Datatypes;

class InboundShipmentItem
{
  private $options = [];
  /**
   * Required attributes, the default is not set yet.
   *
   * @var array
   */
  private $requiredFields = [
    'SellerSKU'       => false,
    'QuantityShipped' => false,
  ];

  public function setSellerSKU( string $sellerSKU )
  {
    $this->options['SellerSKU'] = $sellerSKU;

    $this->requiredFields['SellerSKU'] = true;
  }

  public function setQuantityShipped( int $quantity )
  {
    $this->options['QuantityShipped'] = $quantity;

    $this->requiredFields['QuantityShipped'] = true;
  }

  public function setQuantityInCase( int $quantityInCase )
  {
    $this->options['QuantityInCase'] = $quantityInCase;
  }

  /**
   * @param PrepDetails[] $prepList
   */
  public function setPrepDetailsList( array $prepList )
  {
    foreach ( $prepList as $index => $prepDetails )
    {
      if ( ! $prepDetails instanceof PrepDetails )
      {
        throw new \InvalidArgumentException( 'The prep details list must-have items of PrepDetails data type.' );
      }

      foreach ( $prepDetails->toArray() as $key => $value )
      {
        $this->options[ 'PrepDetails.' . ( $index + 1 ) . '.' . $key ] = $value;
      }
    }
  }

  public function setReleaseDate( int $releaseDate )
  {
    $this->options['ReleaseDate'] = $releaseDate;
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