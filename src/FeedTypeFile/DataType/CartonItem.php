<?php

namespace Sonnenglas\AmazonMws\FeedTypeFile\DataType;

class CartonItem
{
  private $content;
  /**
   * Required attributes, the default is not set yet.
   *
   * @var array
   */
  private $requiredFields = [
    'SKU'             => false,
    'QuantityShipped' => false,
  ];

  public function __construct()
  {
    $this->content .= '<Item>';
  }

  public function setSKU( $sku )
  {
    $this->content .= '<SKU>' . $sku . '</SKU>';

    $this->requiredFields['SKU'] = true;
  }

  public function setQuantityShipped( int $quantityShipped )
  {
    $this->content .= '<QuantityShipped>' . $quantityShipped . '</QuantityShipped>';

    $this->requiredFields['QuantityShipped'] = true;
  }

  public function setQuantityInCase( int $quantityInCase )
  {
    $this->content .= '<QuantityInCase>' . $quantityInCase . '</QuantityInCase>';
  }

  /**
   * @param string|array $expirationDate
   */
  public function setExpirationDate( $expirationDate )
  {
    if ( is_array( $expirationDate ) )
    {
      foreach ( $expirationDate as $date )
      {
        $this->content .= '<ExpirationDate>' . $date . '</ExpirationDate>';
      }
    } else
    {
      $this->content .= '<ExpirationDate>' . $expirationDate . '</ExpirationDate>';
    }
  }

  /**
   * Check required attributes and return XML content.
   *
   * @return string
   */
  public function toXML()
  {
    if ( array_sum( $this->requiredFields ) < count( $this->requiredFields ) )
    {
      throw new \InvalidArgumentException( 'CartonItem missing required attributes' );
    }

    $this->content .= '</Item>';

    return $this->content;
  }
}