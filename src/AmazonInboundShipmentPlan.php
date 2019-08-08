<?php

namespace Sonnenglas\AmazonMws;

use Sonnenglas\AmazonMws\Datatypes\Address;
use Sonnenglas\AmazonMws\Datatypes\InboundShipmentPlanRequestItem;

class AmazonInboundShipmentPlan extends AmazonInboundCore
{
  private $response;

  public function __construct( $s, $mock = false, $m = null )
  {
    parent::__construct( $s, $mock, $m );
    include( $this->env );

    $this->options['Action'] = 'CreateInboundShipmentPlan';
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
      $this->options[ 'ShipFromAddress.' . $key ] = $value;
    }
  }

  /**
   * Set LabelPrepPreference
   *
   * @param string $labelPrepPreference
   */
  public function setLabelPrepPreference( string $labelPrepPreference )
  {
    $this->options['LabelPrepPreference'] = $labelPrepPreference;
  }

  /**
   * Set InboundShipmentPlanRequestItems with its PrepDetailsList
   *
   * @param InboundShipmentPlanRequestItem[] $items
   */
  public function setItems( array $items )
  {
    foreach ( $items as $index => $item )
    {
      if ( ! $item instanceof InboundShipmentPlanRequestItem )
      {
        throw new \InvalidArgumentException( 'The shipment plane item list must-have items of InboundShipmentPlanRequestItem data type.' );
      }

      foreach ( $item->toArray() as $key => $value )
      {
        $this->options[ 'InboundShipmentPlanRequestItems.member.' . ( $index + 1 ) . '.' . $key ] = $value;
      }
    }
  }

  /**
   * Set ShipToCountryCode
   *
   * @param string $countryCode
   */
  public function setShipToCountryCode( string $countryCode )
  {
    $this->options['ShipToCountryCode'] = $countryCode;
  }

  /**
   * Set ShipToCountrySubdivisionCode
   *
   * @param string $countryCode
   */
  public function setShipToCountrySubdivisionCode( string $countryCode )
  {
    $this->options['ShipToCountrySubdivisionCode'] = $countryCode;
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
      'ShipFromAddress.Name',
      'ShipFromAddress.AddressLine1',
      'ShipFromAddress.City',
      'ShipFromAddress.CountryCode',
      'InboundShipmentPlanRequestItems.member.1.SellerSKU',
      'InboundShipmentPlanRequestItems.member.1.Quantity',
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
     * Specifying both ShipToCountryCode and ShipToCountrySubdivisionCode returns an error.
     */
    if ( isset( $this->options['ShipToCountryCode'] ) and isset( $this->options['ShipToCountrySubdivisionCode'] ) )
    {
      throw new \InvalidArgumentException( 'Must Specifying ShipToCountryCode or ShipToCountrySubdivisionCode' );
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