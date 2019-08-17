<?php

namespace Sonnenglas\AmazonMws\FeedTypeFile;

use Sonnenglas\AmazonMws\FeedTypeFile\DataType\Carton;

class CartonContentsRequest
{
  private $feedContent;
  /**
   * Required attributes, the default is not set yet.
   *
   * @var array
   */
  private $requiredFields = [
    'ShipmentId' => false,
    'NumCartons' => false,
    'Carton'     => false,
  ];

  public function __construct()
  {
    $this->feedContent = '<CartonContentsRequest>';
  }

  /**
   * Set Shipment Id
   *
   * @param string $shipmentId
   */
  public function setShipmentId( string $shipmentId )
  {
    $this->feedContent .= '<ShipmentId>' . $shipmentId . '</ShipmentId>';

    $this->requiredFields['ShipmentId'] = true;
  }

  /**
   * Set Cartons Count
   *
   * @param int $numCartons
   */
  public function setNumCartons( int $numCartons )
  {
    $this->feedContent .= '<NumCartons>' . $numCartons . '</NumCartons>';

    $this->requiredFields['NumCartons'] = true;
  }

  /**
   * Set Cartons
   *
   * @param Carton[] $cartons
   */
  public function setCartons( array $cartons )
  {
    foreach ( $cartons as $carton )
    {
      $this->addCarton( $carton );
    }

    $this->requiredFields['Carton'] = true;
  }

  /**
   * Add Carton
   *
   * @param Carton $carton
   */
  public function addCarton( Carton $carton )
  {
    if ( ! $carton instanceof Carton )
    {
      throw new \InvalidArgumentException( 'The Carton list must-have items of Carton data type.' );
    }

    $this->feedContent .= $carton->toXML();

    $this->requiredFields['Carton'] = true;
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
      throw new \InvalidArgumentException( 'CartonContentsRequest missing required attributes' );
    }

    $this->feedContent .= '</CartonContentsRequest>';

    return $this->feedContent;
  }
}