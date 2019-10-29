<?php

namespace Sonnenglas\AmazonMws\DataType;

class InboundShipmentPlanRequestItem
{
  private $options = [];
  /**
   * Required attributes, the default is not set yet.
   *
   * @var array
   */
  private $requiredFields = [
    'SellerSKU' => false,
    'Quantity'  => false,
  ];

  public function setSellerSKU( string $sellerSKU )
  {
    $this->options['SellerSKU'] = $sellerSKU;

    $this->requiredFields['SellerSKU'] = true;
  }

  public function setASIN( string $asin )
  {
    $this->options['ASIN'] = $asin;
  }

  public function setCondition( string $condition )
  {
    $this->options['Condition'] = $condition;
  }

  public function setQuantity( int $quantity )
  {
    $this->options['Quantity'] = $quantity;

    $this->requiredFields['Quantity'] = true;
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
        $this->options[ 'PrepDetailsList.PrepDetails.' . ( $index + 1 ) . '.' . $key ] = $value;
      }
    }
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