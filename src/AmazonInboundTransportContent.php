<?php

namespace Sonnenglas\AmazonMws;

use Sonnenglas\AmazonMws\DataType\PartneredLtlDataInput;
use Sonnenglas\AmazonMws\DataType\PartneredSmallParcelPackageInput;

class AmazonInboundTransportContent extends AmazonInboundCore
{
  private $response;
  private $transportDetailsSet = false;

  public function __construct( $s, $mock = false, $m = null )
  {
    parent::__construct( $s, $mock, $m );
    include( $this->env );
  }

  public function setShipmentId( string $shipmentId )
  {
    $this->options['ShipmentId'] = $shipmentId;
  }

  public function setIsPartnered( bool $isPartnered )
  {
    $this->options['IsPartnered'] = $isPartnered;
  }

  public function setShipmentType( string $shipmentType )
  {
    if ( ! in_array( $shipmentType, Enum::SHIPMENT_TYPES ) )
    {
      throw new \InvalidArgumentException( 'Invalid ShipmentType. pissible: ' . implode( ',', Enum::SHIPMENT_TYPES ) );
    }

    $this->options['ShipmentType'] = $shipmentType;
  }

  /**
   * Set PartneredSmallParcelData to Transport Details.
   *
   * @param string $carrierName
   * @param PartneredSmallParcelPackageInput[] $packageList
   */
  public function setTransportDetailsPartneredSP( string $carrierName, array $packageList )
  {
    $this->options['TransportDetails.PartneredSmallParcelData.CarrierName'] = $carrierName;
    foreach ( $packageList as $boxNum => $package )
    {
      if ( ! $package instanceof PartneredSmallParcelPackageInput )
      {
        throw new \InvalidArgumentException( 'The package list must-have items of PartneredSmallParcelPackageInput data type.' );
      }

      foreach ( $package->toArray() as $key => $value )
      {
        $this->options[ 'TransportDetails.PartneredSmallParcelData.PackageList.member.' . $boxNum . '.' . $key ] = $value;
      }
    }

    $this->transportDetailsSet = true;
  }

  /**
   * Set NonPartneredSmallParcelData to Transport Details.
   *
   * @param string $carrierName
   * @param string[] $packageList
   */
  public function setTransportDetailsNonPartneredSP( string $carrierName, array $packageList )
  {
    $this->options['TransportDetails.NonPartneredSmallParcelData.CarrierName'] = $carrierName;
    foreach ( $packageList as $boxNum => $trackingId )
    {
      $this->options[ 'TransportDetails.NonPartneredSmallParcelData.PackageList.member.' . $boxNum . '.TrackingId' ] = $trackingId;
    }

    $this->transportDetailsSet = true;
  }

  /**
   * Set PartneredLtlData to Transport Details.
   *
   * @param PartneredLtlDataInput $partneredLtlDataInput
   */
  public function setTransportDetailsPartneredLtl( PartneredLtlDataInput $partneredLtlDataInput )
  {
    foreach ( $partneredLtlDataInput->toArray() as $key => $value )
    {
      $this->options[ 'TransportDetails.PartneredLtlData.' . $key ] = $value;
    }

    $this->transportDetailsSet = true;
  }

  /**
   * Set NonPartneredLtlData to Transport Details.
   *
   * @param string $carrierName
   * @param string $proNumber
   */
  public function setTransportDetailsNonPartneredLtl( string $carrierName, string $proNumber )
  {
    $this->options['TransportDetails.NonPartneredLtlData.CarrierName'] = $carrierName;
    $this->options['TransportDetails.NonPartneredLtlData.ProNumber']   = $proNumber;

    $this->transportDetailsSet = true;
  }

  /**
   * PutTransportContent
   *
   * @return bool
   */
  public function put()
  {
    $requiredKeys = [
      'IsPartnered',
      'ShipmentType',
    ];

    /**
     * Check required options
     */
    $missingKeys = array_diff( $requiredKeys, array_keys( $this->options ) );
    if ( $missingKeys )
    {
      throw new \InvalidArgumentException( 'Missing required values: ' . implode( ',', $missingKeys ) );
    }

    /**
     * Check TransportDetails
     */
    if ( ! $this->transportDetailsSet )
    {
      throw new \InvalidArgumentException( 'Need to set any type of TransportDetails.' );
    }

    $this->options['Action'] = 'PutTransportContent';

    return $this->send();
  }

  /**
   * GetTransportContent
   *
   * @return bool
   */
  public function get()
  {
    $this->options['Action'] = 'GetTransportContent';

    return $this->send();
  }

  private function send()
  {
    if ( empty( $this->options['ShipmentId'] ) )
    {
      throw new \InvalidArgumentException( 'ShipmentId is required.' );
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