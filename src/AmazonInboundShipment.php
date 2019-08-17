<?php

namespace Sonnenglas\AmazonMws;

use Sonnenglas\AmazonMws\DataType\Address;
use Sonnenglas\AmazonMws\DataType\InboundShipmentItem;

class AmazonInboundShipment extends AmazonInboundCore
{
  private $response;

  public function __construct( $s, $mock = false, $m = null )
  {
    parent::__construct( $s, $mock, $m );
    include( $this->env );

    $this->options['Action'] = 'CreateInboundShipment';
  }

  /**
   * Set ShipmentId
   *
   * @param string $shipmentId
   */
  public function setShipmentId( string $shipmentId )
  {
    $this->options['ShipmentId'] = $shipmentId;
  }

  public function setShipmentName( string $shipmentName )
  {
    $this->options['InboundShipmentHeader.ShipmentName'] = $shipmentName;
  }

  /**
   * Set Ship from address
   *
   * @param Address $address
   */
  public function setShipFromAddress( Address $address )
  {
    foreach ( $address->toArray() as $key => $value )
    {
      $this->options[ 'InboundShipmentHeader.ShipFromAddress.' . $key ] = $value;
    }
  }

  public function setDestinationFulfillmentCenterId( string $centerId )
  {
    $this->options['InboundShipmentHeader.DestinationFulfillmentCenterId'] = $centerId;
  }

  /**
   * Set LabelPrepPreference
   *
   * @param string $labelPrepPreference
   */
  public function setLabelPrepPreference( string $labelPrepPreference )
  {
    $this->options['InboundShipmentHeader.LabelPrepPreference'] = $labelPrepPreference;
  }

  public function setAreCasesRequired( bool $areCasesRequired )
  {
    $this->options['InboundShipmentHeader.AreCasesRequired'] = $areCasesRequired;
  }

  public function setShipmentStatus( string $shipmentStatus )
  {
    $this->options['InboundShipmentHeader.ShipmentStatus'] = $shipmentStatus;
  }

  public function setIntendedBoxContentsSource( string $intendedBoxContentsSource )
  {
    $this->options['InboundShipmentHeader.IntendedBoxContentsSource'] = $intendedBoxContentsSource;
  }

  /**
   * Set InboundShipmentItem with its PrepDetailsList
   *
   * @param InboundShipmentItem[] $items
   */
  public function setItems( array $items )
  {
    foreach ( $items as $index => $item )
    {
      if ( ! $item instanceof InboundShipmentItem )
      {
        throw new \InvalidArgumentException( 'The shipment item list must-have items of InboundShipmentItem data type.' );
      }

      foreach ( $item->toArray() as $key => $value )
      {
        $this->options[ 'InboundShipmentItems.member.' . ( $index + 1 ) . '.' . $key ] = $value;
      }
    }
  }

  /**
   * send CreateInboundShipmentPlan request to amazon
   *
   * @return bool
   * @throws \Exception
   */
  public function create()
  {
    $requiredKeys = [
      'ShipmentId',
      'InboundShipmentHeader.ShipmentName',
      'InboundShipmentHeader.ShipmentStatus',
      'InboundShipmentHeader.ShipFromAddress.Name',
      'InboundShipmentHeader.ShipFromAddress.AddressLine1',
      'InboundShipmentHeader.ShipFromAddress.City',
      'InboundShipmentHeader.ShipFromAddress.CountryCode',
      'InboundShipmentHeader.LabelPrepPreference',
      'InboundShipmentHeader.DestinationFulfillmentCenterId',
      'InboundShipmentItems.member.1.SellerSKU',
      'InboundShipmentItems.member.1.QuantityShipped',
    ];

    /**
     * Check required options
     */
    $missingKeys = array_diff( $requiredKeys, array_keys( $this->options ) );
    if ( $missingKeys )
    {
      throw new \InvalidArgumentException( 'Missing required values: ' . implode( ',', $missingKeys ) );
    }

    $url = $this->urlbase . $this->urlbranch;

    $query = $this->genQuery();

    $path = $this->options['Action'] . 'Result';

    $response = $this->sendRequest( $url, [ 'Post' => $query ] );

    if ( ! $this->checkResponse( $response ) )
    {
      return false;
    }

    $xml = simplexml_load_string( $response['body'] )->$path;

    $this->parseXML( $xml );

    return true;
  }

  protected function parseXML( $xml )
  {
    $this->response = json_decode( json_encode( $xml ), true );
  }

  public function getResponse()
  {
    if ( isset( $this->response ) )
    {
      return $this->response;
    } else
    {
      return false;
    }
  }
}