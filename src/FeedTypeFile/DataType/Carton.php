<?php

namespace Sonnenglas\AmazonMws\FeedTypeFile\DataType;

class Carton
{
  private $content;
  /**
   * Required attributes, the default is not set yet.
   *
   * @var array
   */
  private $requiredFields = [
    'CartonId' => false,
    'Items'    => false,
  ];

  public function __construct()
  {
    $this->content .= '<Carton>';
  }

  /**
   * Set Carton Id
   *
   * @param string $cartonId
   */
  public function setCartonId( string $cartonId )
  {
    $this->content .= '<CartonId>' . $cartonId . '</CartonId>';

    $this->requiredFields['CartonId'] = true;
  }

  /**
   * Set Items
   *
   * @param CartonItem[] $items
   */
  public function setItems( array $items )
  {
    foreach ( $items as $item )
    {
      $this->addItem( $item );
    }

    $this->requiredFields['Items'] = true;
  }

  /**
   * Add Item
   *
   * @param CartonItem $item
   */
  public function addItem( CartonItem $item )
  {
    if ( ! $item instanceof CartonItem )
    {
      throw new \InvalidArgumentException( 'The Carton Item must-be CartonItem data type.' );
    }

    $this->content .= $item->toXML();

    $this->requiredFields['Items'] = true;
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
      throw new \InvalidArgumentException( 'Carton missing required attributes' );
    }

    $this->content .= '</Carton>';

    return $this->content;
  }
}